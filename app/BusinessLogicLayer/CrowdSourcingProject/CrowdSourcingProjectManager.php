<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\BusinessLogicLayer\gamification\ContributorBadge;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\questionnaire\QuestionnaireGoalManager;
use App\BusinessLogicLayer\UserManager;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\ViewModels\AllCrowdSourcingProjects;
use App\Models\ViewModels\CreateEditCrowdSourcingProject;
use App\Models\ViewModels\CrowdSourcingProjectForLandingPage;
use App\Models\ViewModels\CrowdSourcingProjectSocialMediaMetadata;
use App\Models\ViewModels\CrowdSourcingProjectUnavailable;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Models\ViewModels\QuestionnaireSocialShareButtons;
use App\Notifications\QuestionnaireResponded;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\CrowdSourcingProjectStatusHistoryRepository;
use App\Repository\LanguageRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Utils\FileUploader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CrowdSourcingProjectManager {
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

    public function __construct(CrowdSourcingProjectRepository              $crowdSourcingProjectRepository,
                                QuestionnaireRepository                     $questionnaireRepository,
                                CrowdSourcingProjectStatusManager           $crowdSourcingProjectStatusManager,
                                CrowdSourcingProjectAccessManager           $crowdSourcingProjectAccessManager,
                                CrowdSourcingProjectStatusHistoryRepository $crowdSourcingProjectStatusHistoryRepository,
                                QuestionnaireGoalManager                    $questionnaireGoalManager,
                                LanguageRepository                          $languageRepository,
                                CrowdSourcingProjectColorsManager           $crowdSourcingProjectColorsManager,
                                QuestionnaireResponseRepository             $questionnaireResponseRepository,
                                CrowdSourcingProjectTranslationManager      $crowdSourcingProjectTranslationManager) {
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
    }

    public function getCrowdSourcingProjectsForHomePage(): Collection {
        $projectsWithActiveQuestionnaires = $this->crowdSourcingProjectRepository->getActiveProjectsWithAtLeastOneQuestionnaireWithStatus();
        $projectsWithFinalizedQuestionnaires = $this->crowdSourcingProjectRepository->getActiveProjectsWithAtLeastOneQuestionnaireWithStatus([], QuestionnaireStatusLkp::FINALIZED);
        $projects = $projectsWithActiveQuestionnaires->merge($projectsWithFinalizedQuestionnaires);
        foreach ($projects as $project) {
            $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);
            $project->latestQuestionnaire = $project->questionnaires->last();
        }

        return $projects;
    }

    public function getPastCrowdSourcingProjectsForHomePage(): Collection {
        return $this->crowdSourcingProjectRepository->getPastProjects();
    }

    public function getCrowdSourcingProject(int $id): CrowdSourcingProject {
        $project = $this->crowdSourcingProjectRepository->find($id);
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);

        return $project;
    }

    public function getCrowdSourcingProjectBySlug($project_slug) {
        $project = $this->crowdSourcingProjectRepository->findBy('slug', $project_slug);
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);

        return $project;
    }

    public function getCrowdSourcingProjectViewModelForLandingPage(
        $questionnaireIdRequestedInTheURL,
        $project_slug,
        $openQuestionnaireWhenPageLoads): CrowdSourcingProjectForLandingPage {
        $userId = null;

        // if the user is logged in, get the user id
        if (Auth::check()) {
            $userId = Auth::id();
        } // else, check if the user is anonymous (by checking the cookie) and get the user id
        elseif (isset($_COOKIE[UserManager::$USER_COOKIE_KEY]) && intval($_COOKIE[UserManager::$USER_COOKIE_KEY])) {
            $userId = intval($_COOKIE[UserManager::$USER_COOKIE_KEY]);
        }

        $project = $this->getCrowdSourcingProjectBySlug($project_slug);

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
        if ($feedbackQuestionnaire) {
            $userFeedbackQuestionnaireResponse =
                $this->questionnaireRepository->getUserResponseForQuestionnaire($feedbackQuestionnaire->id, $userId);
        }

        $socialMediaMetadataVM = $this->getSocialMediaMetadataViewModel($project);


        return new CrowdSourcingProjectForLandingPage($project,
            $questionnaire,
            $feedbackQuestionnaire,
            $userResponse,
            $userFeedbackQuestionnaireResponse,
            $countAll,
            $questionnaireGoalVM,
            $socialMediaMetadataVM,
            $this->languageRepository->all(),
            $openQuestionnaireWhenPageLoads,
            $shareUrlForFacebook,
            $shareUrlForTwitter);
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

    public function storeProject(array $attributes) {
        $attributes['user_creator_id'] = Auth::id();

        $attributes = $this->setDefaultValuesForCommonProjectFields($attributes);

        $project = $this->crowdSourcingProjectRepository->create($attributes);

        $this->updateProject($project->id, $attributes);
    }

    public function updateProject($id, array $attributes) {
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
        if (isset($attributes['extra_translations'])) {
            $this->crowdSourcingProjectTranslationManager->storeOrUpdateTranslationsForProject(
                json_decode($attributes['extra_translations']), $project->id, intval($attributes['language_id']));
        }
    }

    protected function setDefaultValuesForCommonProjectFields(array $attributes, CrowdSourcingProject $project = null): array {
        if (!isset($attributes['slug']) || !$attributes['slug']) {
            $attributes['slug'] = Str::slug($attributes['name'], '-');
        }

        if (!isset($attributes['motto_title']) || !$attributes['motto_title']) {
            $attributes['motto_title'] = $attributes['name'];
        }

        if (!isset($attributes['about']) || !$attributes['about']) {
            $attributes['about'] = $attributes['description'];
        }

        if (!isset($attributes['footer']) || !$attributes['footer']) {
            $attributes['footer'] = $attributes['description'];
        }

        if ((!isset($attributes['img_path']) || !$attributes['img_path']) && (!$project || !$project->img_path)) {
            $attributes['img_path'] = '/images/image_temp.png';
        }

        if ((!isset($attributes['logo_path']) || !$attributes['logo_path']) && (!$project || !$project->logo_path)) {
            $attributes['logo_path'] = '/images/image_temp.png';
        }

        if ((!isset($attributes['sm_featured_img_path']) || !$attributes['sm_featured_img_path'])
            && (!$project || !$project->sm_featured_img_path)) {
            $attributes['sm_featured_img_path'] = '/images/image_temp.png';
        }

        if ((!isset($attributes['lp_questionnaire_img_path']) || !$attributes['lp_questionnaire_img_path'])
            && (!$project || !$project->lp_questionnaire_img_path)) {
            $attributes['lp_questionnaire_img_path'] = '/images/image_temp.png';
        }

        if (!isset($attributes['lp_show_speak_up_btn'])) {
            $attributes['lp_show_speak_up_btn'] = false;
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
        $project = $this->populateInitialFileValuesForProjectIfNotSet($project);

        return $this->populateInitialColorValuesForProjectIfNotSet($project);
    }

    public function populateInitialColorValuesForProjectIfNotSet(CrowdSourcingProject $project): CrowdSourcingProject {
        if (!$project->lp_primary_color) {
            $project->lp_primary_color = '#707070';
        }

        return $project;
    }

    public function populateInitialFileValuesForProjectIfNotSet(CrowdSourcingProject $project): CrowdSourcingProject {
        if (!$project->img_path) {
            $project->img_path = '/images/image_temp.png';
        }
        if (!$project->logo_path) {
            $project->logo_path = '/images/image_temp.png';
        }
        if (!$project->sm_featured_img_path) {
            $project->sm_featured_img_path = '/images/image_temp.png';
        }
        if (!$project->lp_questionnaire_img_path) {
            $project->lp_questionnaire_img_path = '/images/bgsectionnaire.webp';
        }

        return $project;
    }

    protected function storeProjectRelatedFiles(array $attributes): array {
        if (isset($attributes['logo'])) {
            $attributes['logo_path'] = FileUploader::uploadAndGetPath($attributes['logo'], 'project_logos');
        }
        if (isset($attributes['img'])) {
            $attributes['img_path'] = FileUploader::uploadAndGetPath($attributes['img'], 'project_img');
        }

        if (isset($attributes['sm_featured_img'])) {
            $attributes['sm_featured_img_path'] = FileUploader::uploadAndGetPath($attributes['sm_featured_img'], 'project_sm_featured_img');
        }

        if (isset($attributes['lp_questionnaire_img'])) {
            $attributes['lp_questionnaire_img_path'] = FileUploader::uploadAndGetPath($attributes['lp_questionnaire_img'], 'project_questionnaire_bg_img');
        }

        return $attributes;
    }

    protected function createProjectStatusHistoryRecord($projectId, $statusId) {
        $this->crowdSourcingProjectStatusHistoryRepository->create([
            'project_id' => $projectId,
            'status_id' => $statusId,
        ]);
    }

    public function getCreateEditProjectViewModel(int $id = null): CreateEditCrowdSourcingProject {
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
        switch ($project->status_id) {
            case CrowdSourcingProjectStatusLkp::FINALIZED:
                $message = 'This project is finalized.<br>Thank you for your contribution!';
                break;
            case CrowdSourcingProjectStatusLkp::UNPUBLISHED:
                $message = 'This project is unpublished.';
                break;
            case CrowdSourcingProjectStatusLkp::DELETED:
                $message = 'This project has been archived.';
                break;
            default:
                $message = 'This project is not currently available';
                break;
        }

        return new CrowdSourcingProjectUnavailable($project, $projects, $message);
    }

    public function getAllCrowdSourcingProjects(): Collection {
        return $this->crowdSourcingProjectRepository->all();
    }

    public function cloneProject(int $id): CrowdSourcingProject {
        return DB::transaction(function () use ($id) {
            $now = Date::now();
            $project = $this->getCrowdSourcingProject($id);
            $project->load(['language', 'status', 'translations']);
            $clone = $project->replicate();
            $clone->name .= ' - Clone';
            $clone->created_at = $now;
            $clone->updated_at = $now;
            $clone->user_creator_id = Auth::id();

            foreach ($project->colors as $color) {
                $clone->colors()->attach($color, ['created_at' => $now, 'updated_at' => $now]);
                // you may set the timestamps to the second argument of attach()
            }
            if ($clone->img_path) {
                $clone->img_path = $this->copyProjectFile($clone->img_path);
            }
            if ($clone->logo_path) {
                $clone->logo_path = $this->copyProjectFile($clone->logo_path);
            }
            if ($clone->lp_questionnaire_img_path) {
                $clone->lp_questionnaire_img_path = $this->copyProjectFile($clone->lp_questionnaire_img_path);
            }
            if ($clone->sm_featured_img_path) {
                $clone->sm_featured_img_path = $this->copyProjectFile($clone->sm_featured_img_path);
            }
            $clone->push();

            return $clone;
        });
    }

    protected function copyProjectFile(string $filePath): string {
        if (!$filePath) {
            return '';
        }
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $newFile = basename($filePath, '.' . $ext);
        $newFile .= '_' . now()->getTimestamp() . '.' . $ext;
        $file = basename($filePath, '.' . $ext);
        $lastDirName = basename(dirname($filePath));
        Storage::copy('public/uploads/' . $lastDirName . '/' . $file . '.' . $ext, 'public/uploads/' . $lastDirName . '/' . $newFile);

        return '/storage/uploads/' . $lastDirName . '/' . $newFile;
    }
}
