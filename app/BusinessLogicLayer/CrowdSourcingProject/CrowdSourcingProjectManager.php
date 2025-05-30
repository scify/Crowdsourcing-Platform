<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\BusinessLogicLayer\Gamification\ContributorBadge;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireGoalManager;
use App\BusinessLogicLayer\User\UserManager;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Language;
use App\Notifications\QuestionnaireResponded;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectStatusHistoryRepository;
use App\Repository\LanguageRepository;
use App\Repository\Problem\ProblemRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Utils\FileHandler;
use App\ViewModels\CrowdSourcingProject\AllCrowdSourcingProjects;
use App\ViewModels\CrowdSourcingProject\CreateEditCrowdSourcingProject;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectForLandingPage;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectForThankYouPage;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectSocialMediaMetadata;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectUnavailable;
use App\ViewModels\Gamification\GamificationBadgeVM;
use App\ViewModels\Questionnaire\QuestionnaireSocialShareButtons;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CrowdSourcingProjectManager {
    const DEFAULT_IMAGE_PATH = '/images/image_temp.png';
    const DEFAULT_IMAGE_PATH_QUESTIONNAIRE_BG = '/images/questionnaire_bg_default.webp';
    const DEFAULT_MAX_VOTES_PER_USER_FOR_SOLUTIONS = 10;
    const DEFAULT_LP_PRIMARY_COLOR = '#F5BA16';
    const DEFAULT_LP_BTN_TEXT_COLOR_THEME = 'dark';

    protected CrowdSourcingProjectRepository $crowdSourcingProjectRepository;
    protected QuestionnaireRepository $questionnaireRepository;
    protected CrowdSourcingProjectStatusManager $crowdSourcingProjectStatusManager;
    protected CrowdSourcingProjectStatusHistoryRepository $crowdSourcingProjectStatusHistoryRepository;
    protected CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager;
    protected QuestionnaireGoalManager $questionnaireGoalManager;
    protected LanguageRepository $languageRepository;
    protected CrowdSourcingProjectColorsManager $crowdSourcingProjectColorsManager;
    protected QuestionnaireResponseRepository $questionnaireResponseRepository;
    protected CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager;
    protected ProblemRepository $crowdSourcingProjectProblemRepository;
    protected UserRoleManager $userRoleManager;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
        QuestionnaireRepository $questionnaireRepository,
        CrowdSourcingProjectStatusManager $crowdSourcingProjectStatusManager,
        CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager,
        CrowdSourcingProjectStatusHistoryRepository $crowdSourcingProjectStatusHistoryRepository,
        QuestionnaireGoalManager $questionnaireGoalManager,
        LanguageRepository $languageRepository,
        CrowdSourcingProjectColorsManager $crowdSourcingProjectColorsManager,
        QuestionnaireResponseRepository $questionnaireResponseRepository,
        CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager,
        ProblemRepository $crowdSourcingProjectProblemRepository,
        UserRoleManager $userRoleManager) {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->crowdSourcingProjectStatusManager = $crowdSourcingProjectStatusManager;
        $this->crowdSourcingProjectStatusHistoryRepository = $crowdSourcingProjectStatusHistoryRepository;
        $this->crowdSourcingProjectAccessManager = $crowdSourcingProjectAccessManager;
        $this->questionnaireGoalManager = $questionnaireGoalManager;
        $this->languageRepository = $languageRepository;
        $this->crowdSourcingProjectColorsManager = $crowdSourcingProjectColorsManager;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->crowdSourcingProjectTranslationManager = $crowdSourcingProjectTranslationManager;
        $this->crowdSourcingProjectProblemRepository = $crowdSourcingProjectProblemRepository;
        $this->userRoleManager = $userRoleManager;
    }

    public function getCrowdSourcingProjectsForHomePage(): Collection {
        $language = $this->languageRepository->where(['language_code' => app()->getLocale()]);
        if (!$language) {
            $language = $this->languageRepository->getDefaultLanguage();
        }
        $projects = $this->crowdSourcingProjectRepository->getActiveProjectsForHomePage($language->id);

        foreach ($projects as $project) {
            // if the model has a "translations" relationship and the first item is not null,
            // then set it as the current translation.
            // otherwise, set the default translation as the current translation

            $project->currentTranslation = $project->translations->first() ?? $project->defaultTranslation;


            if ($project->questionnaires->count() > 0) {
                $project->latestQuestionnaire = $project->questionnaires->last();
            }
        }

        return $projects;
    }

    public function getCrowdSourcingProject(int $id): CrowdSourcingProject {
        $project = $this->crowdSourcingProjectRepository->find($id);
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);

        return $project;
    }

    public function getCrowdSourcingProjectBySlug($project_slug, $withRelationships = []) {
        $project = $this->crowdSourcingProjectRepository->findBy('slug', $project_slug, ['*'], false, $withRelationships);
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);

        // If copy_footer_across_languages is true, ensure the default footer is set
        if ($project->copy_footer_across_languages) {
            $defaultTranslation = $project->defaultTranslation;
            if ($defaultTranslation && $defaultTranslation->footer) {
                $project->currentTranslation->footer = $defaultTranslation->footer;
            }
        }

        return $project;
    }

    public function getCrowdSourcingProjectViewModelForLandingPage(
        int $questionnaireIdRequestedInTheURL,
        string $project_slug): CrowdSourcingProjectForLandingPage {
        $userId = Auth::id() ?? intval($_COOKIE[UserManager::$USER_COOKIE_KEY] ?? 0);

        $project = $this->getCrowdSourcingProjectBySlug($project_slug);
        // if the project's default language is other than English, we need to set the locale to the project's language
        $project_default_lang_code = $project?->defaultTranslation?->language?->language_code;
        if ($project_default_lang_code !== 'en') {
            app()->setLocale($project_default_lang_code);
        }

        $activeQuestionnairesForThisProject = $this->questionnaireRepository->getActiveQuestionnairesForProject($project->id);
        if ($questionnaireIdRequestedInTheURL) {
            $questionnaire = $activeQuestionnairesForThisProject->firstWhere('id', '=', $questionnaireIdRequestedInTheURL);
        } else {
            $questionnaire = $activeQuestionnairesForThisProject->firstWhere('type_id', '=', 1);
        }

        $feedbackQuestionnaire = $activeQuestionnairesForThisProject->firstWhere('type_id', '=', 2);

        $userResponse = null;
        $userFeedbackQuestionnaireResponse = null;
        $questionnaireGoalVM = null;

        $shareUrlForFacebook = '';
        $shareUrlForTwitter = '';
        $countAll = 0;
        if ($questionnaire) {
            $countAll = $this->questionnaireRepository->countAllResponsesForQuestionnaire($questionnaire->id);
            $questionnaireGoalVM = $this->questionnaireGoalManager->getQuestionnaireGoalViewModel($questionnaire, $countAll);
            $userResponse = $this->questionnaireRepository->getUserResponseForQuestionnaire($questionnaire->id, $userId);

            $idOfUserThatCanShareTheQuestionnaire = Auth::check() ? Auth::id() : null;
            $shareButtonsModel = new QuestionnaireSocialShareButtons($questionnaire, $idOfUserThatCanShareTheQuestionnaire);
            $shareUrlForFacebook = $shareButtonsModel->getSocialShareURL($project, 'facebook');
            $shareUrlForTwitter = $shareButtonsModel->getSocialShareURL($project, 'twitter');
        }
        $projectHasPublishedProblems = $this->crowdSourcingProjectProblemRepository->projectHasPublishedProblems($project->id);
        if ($feedbackQuestionnaire) {
            $userFeedbackQuestionnaireResponse =
                $this->questionnaireRepository->getUserResponseForQuestionnaire($feedbackQuestionnaire->id, $userId);
        }

        $socialMediaMetadataVM = $this->getSocialMediaMetadataViewModel($project);


        return new CrowdSourcingProjectForLandingPage($project,
            $questionnaire,
            $feedbackQuestionnaire,
            $projectHasPublishedProblems,
            $userResponse,
            $userFeedbackQuestionnaireResponse,
            $countAll,
            $questionnaireGoalVM,
            $socialMediaMetadataVM,
            $this->languageRepository->all(),
            $shareUrlForFacebook,
            $shareUrlForTwitter);
    }

    public function getCrowdSourcingProjectViewModelForThankYouPage(
        int $questionnaireIdRequestedInTheURL,
        string $project_slug,
        bool $is_moderator_view
    ): CrowdSourcingProjectForThankYouPage {
        // Get the landing page view model
        $landingPageViewModel = $this->getCrowdSourcingProjectViewModelForLandingPage(
            $questionnaireIdRequestedInTheURL,
            $project_slug
        );

        // Retrieve the response ID
        $response_id = $landingPageViewModel->userResponse->id ?? 0;

        $view_model = new CrowdSourcingProjectForThankYouPage(
            $landingPageViewModel->project,
            $landingPageViewModel->questionnaire,
            $landingPageViewModel->feedbackQuestionnaire,
            $landingPageViewModel->projectHasPublishedProblems,
            $landingPageViewModel->userResponse,
            $landingPageViewModel->userFeedbackQuestionnaireResponse,
            $landingPageViewModel->totalResponses,
            $landingPageViewModel->questionnaireGoalVM,
            $landingPageViewModel->socialMediaMetadataVM,
            $landingPageViewModel->languages,
            $landingPageViewModel->shareUrlForFacebook,
            $landingPageViewModel->shareUrlForTwitter
        );

        $view_model->response_id = $response_id;
        $view_model->moderator = $is_moderator_view;
        $view_model->thankYouMode = true;

        return $view_model;
    }

    public function getSocialMediaMetadataViewModel(CrowdSourcingProject $project): CrowdSourcingProjectSocialMediaMetadata {
        return new CrowdSourcingProjectSocialMediaMetadata(
            $project->currentTranslation->sm_title,
            $project->currentTranslation->sm_description,
            $project->sm_featured_img_path,
            $project->currentTranslation->sm_keywords,
            $project->slug
        );
    }

    public function storeProject(array $attributes): CrowdSourcingProject {
        $attributes['user_creator_id'] = Auth::id();

        $attributes = $this->setDefaultValuesForCommonProjectFields($attributes);

        $project = $this->crowdSourcingProjectRepository->create($attributes);

        $this->updateProject($project->id, $attributes);

        return $project;
    }

    public function updateProject($id, array $attributes): void {
        $project = $this->getCrowdSourcingProject($id);
        $attributes = $this->setDefaultValuesForCommonProjectFields($attributes, $project);

        $attributes = $this->setDefaultValuesForSocialMediaFields($attributes);

        $attributes = $this->storeProjectRelatedFiles($attributes);
        $this->createProjectStatusHistoryRecord($id, $attributes['status_id']);

        $attributes['should_send_email_after_questionnaire_response'] =
            (isset($attributes['should_send_email_after_questionnaire_response'])
                && $attributes['should_send_email_after_questionnaire_response'] == 'on') ? 1 : 0;

        $attributes['display_landing_page_banner'] =
            (isset($attributes['display_landing_page_banner'])
                && $attributes['display_landing_page_banner'] == 'on') ? 1 : 0;

        $attributes['copy_footer_across_languages'] =
            (isset($attributes['copy_footer_across_languages'])
                && $attributes['copy_footer_across_languages'] == '1') ? 1 : 0;

        $this->crowdSourcingProjectRepository->update($attributes, $id);
        if ($attributes['status_id'] === CrowdSourcingProjectStatusLkp::DELETED) {
            $this->crowdSourcingProjectRepository->delete($id);
        }
        $colors = [];
        for ($i = 0; $i < count($attributes['color_codes']); $i++) {
            $colors[] = [
                'id' => $attributes['color_ids'][$i],
                'color_name' => $attributes['color_names'][$i],
                'color_code' => $attributes['color_codes'][$i],
            ];
        }
        $this->crowdSourcingProjectColorsManager->saveColorsForCrowdSourcingProject($colors, $id);
        $this->crowdSourcingProjectTranslationManager->storeOrUpdateDefaultTranslationForProject(
            $attributes, $id);

        // Handle extra translations
        if (isset($attributes['extra_translations'])) {
            $extraTranslations = json_decode($attributes['extra_translations'], true);

            // If copy_footer_across_languages is true, copy the footer from default translation to all languages
            if ($attributes['copy_footer_across_languages']) {
                $defaultFooter = $project->defaultTranslation->footer;

                // Update all translations with the default footer
                foreach ($extraTranslations as &$translation) {
                    $translation['footer'] = $defaultFooter;
                }
            }

            $this->crowdSourcingProjectTranslationManager->storeOrUpdateExtraTranslationsForProject(
                $extraTranslations, $project->id, intval($attributes['language_id']));
        }
    }

    protected function setDefaultValuesForCommonProjectFields(array $attributes, ?CrowdSourcingProject $project = null): array {
        if (!isset($attributes['slug']) || !$attributes['slug']) {
            $attributes['slug'] = Str::slug($attributes['name'], '-');
        }

        if (!isset($attributes['motto_title']) || !$attributes['motto_title']) {
            $attributes['motto_title'] = $attributes['name'];
        }

        if (!isset($attributes['about']) || !$attributes['about']) {
            $attributes['about'] = trim($attributes['description']);
        }

        if ((!isset($attributes['img_path']) || !$attributes['img_path']) && (!$project || !$project->img_path)) {
            $attributes['img_path'] = self::DEFAULT_IMAGE_PATH;
        }

        if ((!isset($attributes['logo_path']) || !$attributes['logo_path']) && (!$project || !$project->logo_path)) {
            $attributes['logo_path'] = self::DEFAULT_IMAGE_PATH;
        }

        if ((!isset($attributes['sm_featured_img_path']) || !$attributes['sm_featured_img_path'])
            && (!$project || !$project->sm_featured_img_path)) {
            $attributes['sm_featured_img_path'] = self::DEFAULT_IMAGE_PATH;
        }

        if ((!isset($attributes['lp_questionnaire_img_path']) || !$attributes['lp_questionnaire_img_path'])
            && (!$project || !$project->lp_questionnaire_img_path)) {
            $attributes['lp_questionnaire_img_path'] = self::DEFAULT_IMAGE_PATH_QUESTIONNAIRE_BG;
        }

        if (!isset($attributes['lp_show_speak_up_btn'])) {
            $attributes['lp_show_speak_up_btn'] = true;
        }

        return $attributes;
    }

    protected function setDefaultValuesForSocialMediaFields(array $attributes): array {
        if (!isset($attributes['sm_title']) || !$attributes['sm_title']) {
            $attributes['sm_title'] = $attributes['name'];
        }
        if (!isset($attributes['sm_description']) || !$attributes['sm_description']) {
            $attributes['sm_description'] = $attributes['description'];
        }
        if (!isset($attributes['sm_keywords']) || !$attributes['sm_keywords']) {
            $attributes['sm_keywords'] = str_replace(' ', ',', $attributes['name']);
        } else {
            $attributes['sm_keywords'] = implode(',', $attributes['sm_keywords']);
        }

        return $attributes;
    }

    public function populateInitialValuesForProjectIfNotSet(CrowdSourcingProject $project): CrowdSourcingProject {
        $project->lp_show_speak_up_btn = $project->lp_show_speak_up_btn ?? true;
        $project->max_votes_per_user_for_solutions = $project->max_votes_per_user_for_solutions
            ?? self::DEFAULT_MAX_VOTES_PER_USER_FOR_SOLUTIONS;
        $project = $this->populateInitialFileValuesForProjectIfNotSet($project);

        return $this->populateInitialColorValuesForProjectIfNotSet($project);
    }

    public function populateInitialColorValuesForProjectIfNotSet(CrowdSourcingProject $project): CrowdSourcingProject {
        if (!$project->lp_primary_color) {
            $project->lp_primary_color = self::DEFAULT_LP_PRIMARY_COLOR;
        }
        if (!$project->lp_btn_text_color_theme) {
            $project->lp_btn_text_color_theme = self::DEFAULT_LP_BTN_TEXT_COLOR_THEME;
        }

        return $project;
    }

    public function populateInitialFileValuesForProjectIfNotSet(CrowdSourcingProject $project): CrowdSourcingProject {
        if (!$project->img_path) {
            $project->img_path = self::DEFAULT_IMAGE_PATH;
        }
        if (!$project->logo_path) {
            $project->logo_path = self::DEFAULT_IMAGE_PATH;
        }
        if (!$project->sm_featured_img_path) {
            $project->sm_featured_img_path = self::DEFAULT_IMAGE_PATH;
        }
        if (!$project->lp_questionnaire_img_path) {
            $project->lp_questionnaire_img_path = self::DEFAULT_IMAGE_PATH_QUESTIONNAIRE_BG;
        }

        return $project;
    }

    protected function storeProjectRelatedFiles(array $attributes): array {
        if (isset($attributes['logo'])) {
            $attributes['logo_path'] = FileHandler::uploadAndGetPath($attributes['logo'], 'project_logos');
        }
        if (isset($attributes['img'])) {
            $attributes['img_path'] = FileHandler::uploadAndGetPath($attributes['img'], 'project_img');
        }

        if (isset($attributes['sm_featured_img'])) {
            $attributes['sm_featured_img_path'] = FileHandler::uploadAndGetPath($attributes['sm_featured_img'], 'project_sm_featured_img');
        }

        if (isset($attributes['lp_questionnaire_img'])) {
            $attributes['lp_questionnaire_img_path'] = FileHandler::uploadAndGetPath($attributes['lp_questionnaire_img'], 'project_questionnaire_bg_img');
        }

        return $attributes;
    }

    protected function createProjectStatusHistoryRecord($projectId, $statusId): void {
        $this->crowdSourcingProjectStatusHistoryRepository->create([
            'project_id' => $projectId,
            'status_id' => $statusId,
        ]);
    }

    public function getCreateEditProjectViewModel(?int $id = null): CreateEditCrowdSourcingProject {
        if ($id) {
            $project = $this->getCrowdSourcingProject($id);
        } else {
            $project = $this->crowdSourcingProjectRepository->getModelInstance();
        }

        $project = $this->populateInitialValuesForProjectIfNotSet($project);
        $project->colors = $this->crowdSourcingProjectColorsManager->getColorsForCrowdSourcingProjectOrDefault($project->id);
        $statusesLkp = $this->crowdSourcingProjectStatusManager->getAllCrowdSourcingProjectStatusesLkp();

        $contributorBadge = new ContributorBadge(1, true);
        $contributorBadgeVM = new GamificationBadgeVM($contributorBadge);
        $questionnaire = $this->questionnaireRepository->getModelInstance();


        $templateForNotification = (new QuestionnaireResponded(
            $questionnaire->defaultFieldsTranslation,
            $contributorBadge,
            $contributorBadgeVM,
            $project->defaultTranslation,
            app()->getLocale()
        ))->toMail(null)->render();
        $translations = $this->crowdSourcingProjectTranslationManager->getTranslationsForProject($project);

        // Remove footer field from translations if copyFooterAcrossLanguages is true
        if ($project->copy_footer_across_languages) {
            $translations = $translations->map(function ($translation) {
                unset($translation->footer);

                return $translation;
            });
        }

        return new CreateEditCrowdSourcingProject(
            $project,
            $translations,
            $statusesLkp,
            $this->languageRepository->all(),
            $templateForNotification
        );
    }

    public function getCrowdSourcingProjectsListPageViewModel(): AllCrowdSourcingProjects {
        $user = Auth::user();

        return new AllCrowdSourcingProjects($this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit($user));
    }

    public function getUnavailableCrowdSourcingProjectViewModelForLandingPage($project_slug): CrowdSourcingProjectUnavailable {
        $project = $this->getCrowdSourcingProjectBySlug($project_slug);
        $projects = $this->getCrowdSourcingProjectsForHomePage();
        $message = match ($project->status_id) {
            CrowdSourcingProjectStatusLkp::FINALIZED => __('project.project_finalized_message'),
            CrowdSourcingProjectStatusLkp::UNPUBLISHED => __('project.project_unpublished_message'),
            CrowdSourcingProjectStatusLkp::DELETED => __('project.project_archived_message'),
            default => __('project.project_unavailable_message'),
        };

        return new CrowdSourcingProjectUnavailable($project, $projects, $message);
    }

    public function cloneProject(int $id): CrowdSourcingProject {
        return DB::transaction(function () use ($id) {
            $now = Date::now();
            $project = $this->getCrowdSourcingProject($id);
            $project->load(['language', 'status', 'translations']);
            // remove the defaultTranslation attribute from the model
            unset($project->defaultTranslation);
            unset($project->currentTranslation);
            // clone the project
            $clone = $project->replicate();
            $clone->created_at = $now;
            $clone->updated_at = $now;
            $clone->user_creator_id = Auth::id();

            $clone->slug = $project->slug . '-copy';

            if ($clone->img_path) {
                $clone->img_path = $this->copyProjectFile($clone->img_path, 'project_img');
            }
            if ($clone->logo_path) {
                $clone->logo_path = $this->copyProjectFile($clone->logo_path, 'project_logos');
            }
            if ($clone->lp_questionnaire_img_path) {
                $clone->lp_questionnaire_img_path = $this->copyProjectFile($clone->lp_questionnaire_img_path, 'project_questionnaire_bg_img');
            }
            if ($clone->sm_featured_img_path) {
                $clone->sm_featured_img_path = $this->copyProjectFile($clone->sm_featured_img_path, 'project_sm_featured_img');
            }
            $clone->push();

            // change the name of the default translation of the cloned project
            $this->crowdSourcingProjectTranslationManager->storeOrUpdateDefaultTranslationForProject([
                'name' => $project->defaultTranslation->name . ' - Copy',
                'description' => $project->defaultTranslation->description,
                'motto_title' => $project->defaultTranslation->motto_title,
                'motto_subtitle' => $project->defaultTranslation->motto_subtitle,
                'about' => $project->defaultTranslation->about,
                'sm_title' => $project->defaultTranslation->sm_title,
                'sm_description' => $project->defaultTranslation->sm_description,
                'sm_keywords' => $project->defaultTranslation->sm_keywords,
                'language_id' => $project->defaultTranslation->language_id,
                'footer' => $project->defaultTranslation->footer,
            ], $clone->id);

            // we need to also copy the extra translations
            $extraTranslations = $this->crowdSourcingProjectTranslationManager->getTranslationsForProject($project);
            // set the name only of the default translation as the name of the cloned project + ' - Copy'
            // find the default translation inside the extra translations and set the name to the new name
            $extraTranslations->each(function ($translation) use ($clone) {
                if ($translation->language_id === $clone->defaultTranslation->language_id) {
                    $translation->name = $clone->defaultTranslation->name;
                }
            });

            $this->crowdSourcingProjectTranslationManager->storeOrUpdateExtraTranslationsForProject(
                $extraTranslations->toArray(), $clone->id, $project->defaultTranslation->language_id);

            foreach ($project->colors as $color) {
                $cloneColor = $color->replicate();
                $cloneColor->project_id = $clone->id;
                $cloneColor->save();
            }

            return $clone;
        });
    }

    protected function copyProjectFile(string $filePath, string $dirName): string {
        // copy the file to the new location
        $newPath = FileHandler::copyFile($filePath, $dirName);

        // return the new path
        return $newPath;
    }

    public function getAllCrowdSourcingProjectsWithDefaultTranslation(): Collection {
        $projects = $this->crowdSourcingProjectRepository->getAllProjectsWithDefaultTranslation();

        return $projects;
    }

    public function getCrowdSourcingProjectsForManagement(): Collection {
        $user = Auth::user();
        $user_creator_id = $this->userRoleManager->userHasAdminRole($user) ? null : $user->id;

        return $this->crowdSourcingProjectRepository->getProjectsForManagement($user_creator_id);
    }

    public function getDefaultLanguageForProject(string $projectSlug): Language {
        $project = $this->getCrowdSourcingProjectBySlug($projectSlug);

        return $project->defaultTranslation->language;
    }
}
