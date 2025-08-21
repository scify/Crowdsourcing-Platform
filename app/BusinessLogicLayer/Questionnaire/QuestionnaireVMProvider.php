<?php

declare(strict_types=1);

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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class QuestionnaireVMProvider {
    public function __construct(protected QuestionnaireRepository $questionnaireRepository, protected QuestionnaireManager $questionnaireManager, protected CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager, protected LanguageManager $languageManager, protected QuestionnaireStatisticsPageVisibilityLkpRepository $questionnaireStatisticsPageVisibilityLkpRepository, protected QuestionnaireTranslationRepository $questionnaireTranslationRepository, protected QuestionnaireFieldsTranslationManager $questionnaireFieldsTranslationManager, protected CrowdSourcingProjectManager $crowdSourcingProjectManager, private readonly CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager) {}

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
            $projectInfoArray = json_decode('[' . $questionnaire->project_info . ']', true);

            $questionnaire->project_info = $projectInfoArray;

            // Initialize the arrays
            $project_names = [];
            $project_slugs = [];
            $project_default_locales = [];

            foreach ($projectInfoArray as $projectInfo) {
                $project_names[] = $projectInfo['name'];
                $project_slugs[] = $projectInfo['slug'];
                $project_default_locales[] = $projectInfo['default_locale'];
            }

            // Assign or use as needed
            $questionnaire->project_names = implode(', ', $project_names);
            $questionnaire->project_slugs = implode(', ', $project_slugs);
            $questionnaire->urls = [];
            if ($this->shouldShowLinkForQuestionnaire($questionnaire)) {
                foreach ($project_slugs as $index => $projectSlug) {
                    $questionnaire->urls[] = [
                        'project_name' => $project_names[$index],
                        'url' => $this->getQuestionnaireURL(trim((string) $projectSlug), $questionnaire->id, $project_default_locales[$index]),
                    ];
                }
            }

            $questionnaire->moderator_add_response_urls = [];

            foreach ($project_slugs as $index => $project_slug) {
                $questionnaire->moderator_add_response_urls[] = [
                    'url' => $this->getQuestionnaireModeratorAddResponseURL($project_slug, $questionnaire->id, $project_default_locales[$index]),
                    'project_name' => $project_names[$index],
                ];
            }
        }

        return new ManageQuestionnaires($questionnaires, $availableStatuses);
    }

    protected function shouldShowLinkForQuestionnaire($questionnaire): bool {
        return in_array($questionnaire->status_id, [QuestionnaireStatusLkp::DRAFT, QuestionnaireStatusLkp::PUBLISHED]);
    }

    protected function getQuestionnaireURL(string $project_slug, int $questionnaire_id, string $project_default_locale): string {
        return route('show-questionnaire-page', ['locale' => $project_default_locale, 'project' => $project_slug, 'questionnaire' => $questionnaire_id]);
    }

    protected function getQuestionnaireModeratorAddResponseURL(string $project_slug, int $questionnaire_id, string $project_default_locale): string {
        return url(sprintf('/%s/backoffice/%s/questionnaire/%d/moderator-add-answer', $project_default_locale, $project_slug, $questionnaire_id));
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
        $languages = $this->getLanguagesForQuestionnairePage($questionnaire);

        return new QuestionnairePage($questionnaire, $userResponse, $project, $languages, false);
    }

    public function getViewModelForQuestionnaireResponseModeratorPage(string $locale, CrowdSourcingProject $project, Questionnaire $questionnaire): QuestionnairePage {
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);
        $questionnaire->currentTranslation = $this->getTranslationForQuestionnaire($questionnaire, $locale);

        $languages = $this->getLanguagesForQuestionnairePage($questionnaire);

        return new QuestionnairePage($questionnaire, null, $project, $languages, true);
    }

    private function getTranslationForQuestionnaire(Questionnaire $questionnaire, string $language_code): QuestionnaireFieldsTranslation {
        $language = $this->languageManager->getLanguageByCode($language_code);
        $translation = null;
        if ($language) {
            $translation = $this->questionnaireTranslationRepository->where(['questionnaire_id' => $questionnaire->id, 'language_id' => $language->id]);
        }

        return $translation ?: $this->questionnaireTranslationRepository->where(['questionnaire_id' => $questionnaire->id, 'language_id' => $questionnaire->default_language_id]);
    }

    protected function getLanguagesForQuestionnairePage(Questionnaire $questionnaire): Collection {
        $languages = collect();
        if ($questionnaire->id == 34) {
            $currentTranslationLanguage = $this->languageManager->getLanguageById($questionnaire->currentTranslation->language_id);
            $languages->push($currentTranslationLanguage);
            if ($currentTranslationLanguage->language_code === 'en') {
                $languages->push($this->languageManager->getLanguageByCode('fr'));
                $languages->push($this->languageManager->getLanguageByCode('nl'));
            }
        } else {
            $languages = collect($this->languageManager->getAllLanguages());
        }

        return $languages;
    }
}
