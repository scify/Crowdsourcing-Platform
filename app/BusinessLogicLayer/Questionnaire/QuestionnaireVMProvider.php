<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireTranslationRepository;
use App\Repository\Questionnaire\Statistics\QuestionnaireStatisticsPageVisibilityLkpRepository;
use App\ViewModels\Questionnaire\CreateEditQuestionnaire;
use App\ViewModels\Questionnaire\ManageQuestionnaires;
use App\ViewModels\Questionnaire\QuestionnairePage;
use Illuminate\Support\Facades\Auth;

class QuestionnaireVMProvider {
    protected QuestionnaireRepository $questionnaireRepository;
    protected CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager;
    protected LanguageManager $languageManager;
    protected QuestionnaireStatisticsPageVisibilityLkpRepository $questionnaireStatisticsPageVisibilityLkpRepository;
    protected QuestionnaireTranslationRepository $questionnaireTranslationRepository;
    protected QuestionnaireManager $questionnaireManager;
    protected QuestionnaireFieldsTranslationManager $questionnaireFieldsTranslationManager;
    protected CrowdSourcingProjectManager $crowdSourcingProjectManager;
    private CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
        QuestionnaireManager $questionnaireManager,
        CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager,
        LanguageManager $languageManager,
        QuestionnaireStatisticsPageVisibilityLkpRepository $questionnaireStatisticsPageVisibilityLkpRepository,
        QuestionnaireTranslationRepository $questionnaireTranslationRepository,
        QuestionnaireFieldsTranslationManager $questionnaireFieldsTranslationManager,
        CrowdSourcingProjectManager $crowdSourcingProjectManager,
        CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->crowdSourcingProjectAccessManager = $crowdSourcingProjectAccessManager;
        $this->languageManager = $languageManager;
        $this->questionnaireStatisticsPageVisibilityLkpRepository = $questionnaireStatisticsPageVisibilityLkpRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        $this->questionnaireManager = $questionnaireManager;
        $this->questionnaireFieldsTranslationManager = $questionnaireFieldsTranslationManager;
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->crowdSourcingProjectTranslationManager = $crowdSourcingProjectTranslationManager;
    }

    public function getCreateEditQuestionnaireViewModel($id = null): CreateEditQuestionnaire {
        if ($id) {
            $questionnaire = $this->questionnaireRepository->find($id, ['*'], ['projects']);
            $title = 'Edit Questionnaire';
        } else {
            $questionnaire = $this->questionnaireRepository->getModelInstance();
            $questionnaire->prerequisite_order = 1;
            $questionnaire->max_votes_num = 10;
            $questionnaire->show_general_statistics = true;
            $questionnaire->respondent_auth_required = 0;
            $questionnaire->show_file_type_questions_to_statistics_page_audience = 0;
            $title = 'Create Questionnaire';
        }
        $projects = $this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit(Auth::user());
        $languages = $this->languageManager->getAllLanguages();
        $questionnaireStatisticsPageVisibilityLkp = $this->questionnaireStatisticsPageVisibilityLkpRepository->all();

        return new CreateEditQuestionnaire($questionnaire,
            $projects,
            $languages,
            $title,
            $questionnaireStatisticsPageVisibilityLkp,
            $this->questionnaireFieldsTranslationManager->getFieldsTranslationsForQuestionnaire($questionnaire)

        );
    }

    public function getAllQuestionnairesPageViewModel(): ManageQuestionnaires {
        $projectTheUserHasAccessTo = $this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit(Auth::user());
        $questionnaires = $this->questionnaireRepository->getAllQuestionnairesWithRelatedInfo($projectTheUserHasAccessTo->pluck('id')->toArray());
        foreach ($questionnaires as $questionnaire) {
            if ($this->shouldShowLinkForQuestionnaire($questionnaire)) {
                $projectSlugs = explode(',', $questionnaire->project_slugs);
                $projectNames = explode(',', $questionnaire->project_names);
                $questionnaire->urls = [];
                foreach ($projectSlugs as $index => $projectSlug) {
                    $questionnaire->urls[] = [
                        'project_name' => $projectNames[$index],
                        'url' => $this->getQuestionnaireURL(trim($projectSlug), $questionnaire->id),
                    ];
                }
            }
        }
        $availableStatuses = $this->questionnaireRepository->getAllQuestionnaireStatuses();

        return new ManageQuestionnaires($questionnaires, $availableStatuses);
    }

    public function getViewModelForQuestionnaireResponseModeratorPage(CrowdSourcingProject $project, Questionnaire $questionnaire): QuestionnairePage {
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);

        $languages = $this->languageManager->getAllLanguages();

        return new QuestionnairePage($questionnaire, null, $project, $languages, false);
    }

    protected function shouldShowLinkForQuestionnaire($questionnaire): bool {
        return in_array($questionnaire->status_id, [QuestionnaireStatusLkp::DRAFT, QuestionnaireStatusLkp::PUBLISHED]);
    }

    protected function getQuestionnaireURL(string $projectSlug, int $questionnaireId): string {
        return route('show-questionnaire-page', ['project' => $projectSlug, 'questionnaire' => $questionnaireId]);
    }

    public function getViewModelForQuestionnairePage(CrowdSourcingProject $project, Questionnaire $questionnaire): QuestionnairePage {
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);
        $user = Auth::user();
        $userResponse = null;
        if ($user) {
            $userResponse = $this->questionnaireRepository->getUserResponseForQuestionnaire($questionnaire->id, $user->id);
        }
        $languages = $this->languageManager->getAllLanguages();

        return new QuestionnairePage($questionnaire, $userResponse, $project, $languages, false);
    }
}
