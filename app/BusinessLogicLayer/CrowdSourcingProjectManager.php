<?php

namespace App\BusinessLogicLayer;

use App\BusinessLogicLayer\gamification\ContributorBadge;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\CrowdSourcingProject;
use App\Models\Questionnaire;
use App\Models\ViewModels\AllCrowdSourcingProjects;
use App\Models\ViewModels\CreateEditCrowdSourcingProject;
use App\Models\ViewModels\CrowdSourcingProjectForLandingPage;
use App\Models\ViewModels\CrowdSourcingProjectSocialMediaMetadata;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Notifications\QuestionnaireResponded;
use App\Repository\CrowdSourcingProjectCommunicationResourcesRepository;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\CrowdSourcingProjectStatusHistoryRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireTranslationRepository;
use App\Utils\FileUploader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CrowdSourcingProjectManager
{
    protected $crowdSourcingProjectRepository;
    protected $questionnaireRepository;
    protected $questionnaireTranslationRepository;
    protected $crowdSourcingProjectStatusManager;
    protected $crowdSourcingProjectStatusHistoryRepository;
    protected $crowdSourcingProjectAccessManager;
    protected $questionnaireGoalManager;
    protected $currentQuestionnaireProvider;
    protected $crowdSourcingProjectCommunicationResourcesManager;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
                                QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireTranslationRepository $questionnaireTranslationRepository,
                                CrowdSourcingProjectStatusManager $crowdSourcingProjectStatusManager,
                                CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager,
                                CrowdSourcingProjectStatusHistoryRepository $crowdSourcingProjectStatusHistoryRepository,
                                QuestionnaireGoalManager $questionnaireGoalManager,
                                CurrentQuestionnaireProvider $currentQuestionnaireProvider,
                                CrowdSourcingProjectCommunicationResourcesManager $crowdSourcingProjectCommunicationResourcesManager)
    {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        $this->crowdSourcingProjectStatusManager = $crowdSourcingProjectStatusManager;
        $this->crowdSourcingProjectStatusHistoryRepository = $crowdSourcingProjectStatusHistoryRepository;
        $this->crowdSourcingProjectAccessManager = $crowdSourcingProjectAccessManager;
        $this->questionnaireGoalManager = $questionnaireGoalManager;
        $this->currentQuestionnaireProvider = $currentQuestionnaireProvider;
        $this->crowdSourcingProjectCommunicationResourcesManager = $crowdSourcingProjectCommunicationResourcesManager;
    }

    public function getAllCrowdSourcingProjects(): Collection {
        return $this->crowdSourcingProjectRepository->all();
    }

    public function getCrowdSourcingProjectsForHomePage(): Collection {
        return $this->crowdSourcingProjectRepository->getActiveProjectsWithAtLeastOneActiveQuestionnaire();
    }

    public function getCrowdSourcingProject(int $id): CrowdSourcingProject {
        return $this->crowdSourcingProjectRepository->find($id);
    }

    public function getCrowdSourcingProjectBySlug($project_slug) {
        return $this->crowdSourcingProjectRepository->findBy('slug', $project_slug)->first();
    }

    public function getCrowdSourcingProjectViewModelForLandingPage($questionnaireId, $openQuestionnaireWhenPageLoads, $project_slug):
    CrowdSourcingProjectForLandingPage {
        $project = $this->getCrowdSourcingProjectBySlug($project_slug);

        $questionnaire = null;
        $userResponse = null;
        $questionnaireGoalVM = null;
        $allResponses = collect([]);
        $allLanguagesForQuestionnaire = collect([]);

        if($questionnaireId)
            $questionnaire = $this->questionnaireRepository->find($questionnaireId);
        else
            $questionnaire = $this->currentQuestionnaireProvider->getCurrentQuestionnaire($project->id, Auth::id());

        if ($questionnaire) {
            $questionnaireGoalVM = $this->questionnaireGoalManager->getQuestionnaireGoalViewModel($questionnaire);
            $userResponse = $this->questionnaireRepository->getUserResponseForQuestionnaire($questionnaire->id, Auth::id());
            $allResponses = $this->questionnaireRepository->getAllResponsesForQuestionnaire($questionnaire->id);
            $allLanguagesForQuestionnaire = $this->questionnaireTranslationRepository->getAvailableLanguagesForQuestionnaire($questionnaire);
            if ($userResponse!=null)
                $openQuestionnaireWhenPageLoads = false; //user has already responded
        }

        $socialMediaMetadataVM = $this->getSocialMediaMetadataViewModel($project);
        return new CrowdSourcingProjectForLandingPage($project, $questionnaire,
            $userResponse,
            $allResponses,
            $allLanguagesForQuestionnaire,
            $openQuestionnaireWhenPageLoads,
            $questionnaireGoalVM,
            $socialMediaMetadataVM);
    }


    public function getSocialMediaMetadataViewModel(CrowdSourcingProject $project): CrowdSourcingProjectSocialMediaMetadata {
        return new CrowdSourcingProjectSocialMediaMetadata(
            $project->sm_title,
            $project->sm_description,
            $project->sm_featured_img_path,
            $project->sm_keywords,
            $project->slug
        );
    }

    public function createProject(array $attributes) {

        if(! isset($attributes['slug'])) {
            $attributes['slug'] = Str::slug($attributes['name'], '-');
        }

        $attributes['user_creator_id'] = Auth::id();

        $attributes = $this->storeProjectRelatedFiles($attributes);

        $project = $this->crowdSourcingProjectRepository->create($attributes);
        $this->crowdSourcingProjectCommunicationResourcesManager->createOrUpdateCommunicationResourcesForProject($project, [
            'questionnaire_response_email_intro_text' => $attributes['questionnaire_response_email_intro_text'],
            'questionnaire_response_email_outro_text' => $attributes['questionnaire_response_email_outro_text']
        ]);

        $this->createProjectStatusHistoryRecord($project->id, $attributes['status_id']);

        return $project;
    }

    public function updateCrowdSourcingProject($id, array $attributes) {
        $project = $this->getCrowdSourcingProject($id);

        if(!isset($attributes['sm_title']) || !$attributes['sm_title'])
            $attributes['sm_title'] = $project->name;
        if(!isset($attributes['sm_description']) || !$attributes['sm_description'])
            $attributes['sm_description'] = strip_tags($project->motto);
        if(!isset($attributes['sm_keywords']) || !$attributes['sm_keywords'])
            $attributes['sm_keywords'] = str_replace(' ' , ',', $project->name);

        $attributes = $this->storeProjectRelatedFiles($attributes);
        $this->createProjectStatusHistoryRecord($id, $attributes['status_id']);
        $this->crowdSourcingProjectRepository->update($attributes, $id);
        $this->crowdSourcingProjectCommunicationResourcesManager->createOrUpdateCommunicationResourcesForProject($project, [
            'questionnaire_response_email_intro_text' => $attributes['questionnaire_response_email_intro_text'],
            'questionnaire_response_email_outro_text' => $attributes['questionnaire_response_email_outro_text']
        ]);
        if($attributes['status_id'] === CrowdSourcingProjectStatusLkp::DELETED)
            $this->crowdSourcingProjectRepository->delete($id);
    }

    public function populateInitialValuesForProjectIfNotSet(CrowdSourcingProject $project) {
        $project = $this->populateInitialFileValuesForProjectIfNotSet($project);
        return $this->populateInitialColorValuesForProjectIfNotSet($project);
    }

    public function populateInitialColorValuesForProjectIfNotSet(CrowdSourcingProject $project) {
        if(!$project->lp_motto_color)
            $project->lp_motto_color = '#ffffff';
        if(!$project->lp_about_bg_color)
            $project->lp_about_bg_color = '#ffffff';
        if(!$project->lp_about_color)
            $project->lp_about_color = '#666666';
        if(!$project->lp_questionnaire_color)
            $project->lp_questionnaire_color = '#076ec1';
        if(!$project->lp_footer_bg_color)
            $project->lp_footer_bg_color = '#ffffff';
        if(!$project->lp_footer_color)
            $project->lp_footer_color = '#000000';
        if(!$project->lp_questionnaire_btn_color)
            $project->lp_questionnaire_btn_color = '#ffffff';
        if(!$project->lp_questionnaire_btn_bg_color)
            $project->lp_questionnaire_btn_bg_color = '#004f9f';
        if(!$project->lp_questionnaire_goal_title_color)
            $project->lp_questionnaire_goal_title_color = '#076ec1';
        if(!$project->lp_questionnaire_goal_color)
            $project->lp_questionnaire_goal_color = '#333333';
        if(!$project->lp_questionnaire_goal_bg_color)
            $project->lp_questionnaire_goal_bg_color = '#ffffff';
        if(!$project->lp_newsletter_title_color)
            $project->lp_newsletter_title_color = '#076ec1';
        if(!$project->lp_newsletter_color)
            $project->lp_newsletter_color = '#333333';
        if(!$project->lp_newsletter_bg_color)
            $project->lp_newsletter_bg_color = '#f3fafe';
        if(!$project->lp_newsletter_btn_color)
            $project->lp_newsletter_btn_color = '#ffffff';
        if(!$project->lp_newsletter_btn_bg_color)
            $project->lp_newsletter_btn_bg_color = '#004f9f';

        return $project;
    }

    public function populateInitialFileValuesForProjectIfNotSet(CrowdSourcingProject $project) {
        if(!$project->img_path)
            $project->img_path = '/images/image_temp.png';
        if(!$project->logo_path)
            $project->logo_path = '/images/image_temp.png';
        if(!$project->sm_featured_img_path)
            $project->sm_featured_img_path = '/images/image_temp.png';
        if(!$project->lp_questionnaire_img_path)
            $project->lp_questionnaire_img_path = '/images/bgsectionnaire.png';

        return $project;
    }

    protected function storeProjectRelatedFiles(array $attributes) {

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
            'status_id' => $statusId
        ]);
    }

    public function getCreateEditProjectViewModel(int $id = null) {
        if($id)
            $project = $this->getCrowdSourcingProject($id);
        else {
            $project = $this->crowdSourcingProjectRepository->getModelInstance();
        }

        if(!$project->communicationResources()->exists())
            $project->communicationResources = $this->crowdSourcingProjectCommunicationResourcesManager->getDefaultModelInstance();

        $project = $this->populateInitialValuesForProjectIfNotSet($project);

        $statusesLkp = $this->crowdSourcingProjectStatusManager->getAllCrowdSourcingProjectStatusesLkp();

        $contributorBadge = new ContributorBadge(1, true);
        $contributorBadgeVM = new GamificationBadgeVM($contributorBadge);
        $questionnaire = $this->questionnaireRepository->getModelInstance();
        $questionnaire->title = 'Test Questionnaire';

        $notification = (new QuestionnaireResponded(
            $questionnaire,
            $contributorBadge,
            $contributorBadgeVM,
            $project->communicationResources
        ))->toMail(null)->render();

        return new CreateEditCrowdSourcingProject($project, $statusesLkp, $notification);
    }

    public function getCrowdSourcingProjectsListPageViewModel() {
        $user = Auth::user();
        return new AllCrowdSourcingProjects($this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit($user));
    }
}
