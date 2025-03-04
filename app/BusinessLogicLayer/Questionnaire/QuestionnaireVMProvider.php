<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
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
        $availableStatuses = $this->questionnaireRepository->getAllQuestionnaireStatuses();
        $project_ids = $projectTheUserHasAccessTo->pluck('id')->toArray();
        if (empty($project_ids)) {
            return new ManageQuestionnaires([], $availableStatuses);
        }
        $questionnaires = $this->questionnaireRepository->getAllQuestionnairesWithRelatedInfo($project_ids);
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
        // get the locale for the default language of the project
        $locale = $this->crowdSourcingProjectManager->getDefaultLanguageForProject($projectSlug)->lang_code;

        return route('show-questionnaire-page', ['locale' => $locale, 'project' => $projectSlug, 'questionnaire' => $questionnaireId]);
    }

    public function getViewModelForQuestionnairePage(CrowdSourcingProject $project, Questionnaire $questionnaire): QuestionnairePage {
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);
        $questionnaire->currentTranslation = $this->getTranslationForQuestionnaire($questionnaire, app()->getLocale());
        $user = Auth::user();
        $userResponse = null;
        if ($user) {
            $userResponse = $this->questionnaireRepository->getUserResponseForQuestionnaire($questionnaire->id, $user->id);
        }

        // TODO: Restore after INDEU project
        // $languages = $this->languageManager->getAllLanguages();

        // TODO: Remove after INDEU project
        $languages = collect();
        if ($questionnaire->id == 34) {
            $currentTranslationLanguage = $this->languageManager->getLanguageById($questionnaire->currentTranslation->language_id);
            $languages->push($currentTranslationLanguage);
            if ($currentTranslationLanguage->code === 'en') {
                $languages->push($this->languageManager->getLanguageByCode('fr'));
                $languages->push($this->languageManager->getLanguageByCode('nl'));
            }
        } else {
            $languages = collect($this->languageManager->getAllLanguages());
        }

        return new QuestionnairePage($questionnaire, $userResponse, $project, $languages, false);
    }

    private function getTranslationForQuestionnaire(Questionnaire $questionnaire, string $language_code): QuestionnaireFieldsTranslation {
        $language = $this->languageManager->getLanguageByCode($language_code);
        $translation = null;
        if ($language) {
            $translation = $this->questionnaireTranslationRepository->where(['questionnaire_id' => $questionnaire->id, 'language_id' => $language->id]);
        }

        return $translation ?: $this->questionnaireTranslationRepository->where(['questionnaire_id' => $questionnaire->id, 'language_id' => $questionnaire->default_language_id]);
    }
}
