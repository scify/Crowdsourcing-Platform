<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\Models\ViewModels\CreateEditQuestionnaire;
use App\Models\ViewModels\ManageQuestionnaires;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireTranslationRepository;
use App\Repository\Questionnaire\Statistics\QuestionnaireStatisticsPageVisibilityLkpRepository;
use Illuminate\Support\Facades\Auth;

class QuestionnaireVMProvider {

    protected $questionnaireRepository;
    protected $crowdSourcingProjectAccessManager;
    protected $languageManager;
    protected $questionnaireStatisticsPageVisibilityLkpRepository;
    protected $questionnaireTranslationRepository;
    protected $questionnaireManager;

    public function __construct(QuestionnaireRepository                            $questionnaireRepository,
                                QuestionnaireManager                               $questionnaireManager,
                                CrowdSourcingProjectAccessManager                  $crowdSourcingProjectAccessManager,
                                LanguageManager                                    $languageManager,
                                QuestionnaireStatisticsPageVisibilityLkpRepository $questionnaireStatisticsPageVisibilityLkpRepository,
                                QuestionnaireTranslationRepository                 $questionnaireTranslationRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->crowdSourcingProjectAccessManager = $crowdSourcingProjectAccessManager;
        $this->languageManager = $languageManager;
        $this->questionnaireStatisticsPageVisibilityLkpRepository = $questionnaireStatisticsPageVisibilityLkpRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        $this->questionnaireManager = $questionnaireManager;
    }

    public function getCreateEditQuestionnaireViewModel($id = null): CreateEditQuestionnaire {
        if ($id) {
            $questionnaire = $this->questionnaireRepository->find($id, array('*'), ['projects']);
            $title = "Edit Questionnaire";
        } else {
            $questionnaire = $this->questionnaireRepository->getModelInstance();
            $questionnaire->default_language_id = 6;
            $questionnaire->prerequisite_order = 1;
            $title = "Create Questionnaire";
        }
        $projects = $this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit(Auth::user());
        $languages = $this->languageManager->getAllLanguages();
        $questionnaireStatisticsPageVisibilityLkp = $this->questionnaireStatisticsPageVisibilityLkpRepository->all();
        return new CreateEditQuestionnaire($questionnaire, $projects, $languages, $title, $questionnaireStatisticsPageVisibilityLkp);
    }

    public function getAllQuestionnairesPageViewModel(): ManageQuestionnaires {
        $projectTheUserHasAccessTo = $this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit(Auth::user());
        $questionnaires = $this->questionnaireRepository->getAllQuestionnairesWithRelatedInfo($projectTheUserHasAccessTo->pluck('id')->toArray());
        foreach ($questionnaires as $questionnaire) {
            if ($this->shouldShowLinkForQuestionnaire($questionnaire)) {
                $projectSlugs = explode(',', $questionnaire->project_slugs);
                $projectNames = explode(',', $questionnaire->project_names);
                $questionnaire->urls = [];
                foreach ($projectSlugs as $index => $projectSlug)
                    array_push(
                        $questionnaire->urls,
                        [
                            'project_name' => $projectNames[$index],
                            'url' => $this->getQuestionnaireURL($projectSlug, $questionnaire->id)
                        ]
                    );
            }

        }
        $availableStatuses = $this->questionnaireRepository->getAllQuestionnaireStatuses();
        return new ManageQuestionnaires($questionnaires, $availableStatuses);
    }

    protected function shouldShowLinkForQuestionnaire($questionnaire): bool {
        return in_array($questionnaire->status_id, [QuestionnaireStatusLkp::DRAFT, QuestionnaireStatusLkp::PUBLISHED]);
    }

    protected function getQuestionnaireURL($projectSlug, $questionnaireId): string {
        return url('/en/' . trim($projectSlug)) . '?open=1&questionnaireId=' . $questionnaireId;
    }
}
