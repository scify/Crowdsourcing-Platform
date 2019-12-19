<?php

namespace App\BusinessLogicLayer;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\ViewModels\CreateEditCrowdSourcingProject;
use App\Models\ViewModels\CrowdSourcingProjectForLandingPage;
use App\Models\ViewModels\CrowdSourcingProjectGoal;
use App\Models\ViewModels\CrowdSourcingProjectUnavailable;
use App\Models\ViewModels\reports\QuestionnaireReportFilters;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireTranslationRepository;
use App\Utils\FileUploader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JsonSchema\Exception\ResourceNotFoundException;

define('DEFAULT_PROJECT_ID', config('app.project_id'));

class CrowdSourcingProjectManager
{
    protected $crowdSourcingProjectRepository;
    protected $questionnaireRepository;
    protected $questionnaireTranslationRepository;
    protected $crowdSourcingProjectStatusManager;
    const DEFAULT_PROJECT_ID = DEFAULT_PROJECT_ID;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
                                QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireTranslationRepository $questionnaireTranslationRepository,
                                CrowdSourcingProjectStatusManager $crowdSourcingProjectStatusManager)
    {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        $this->crowdSourcingProjectStatusManager = $crowdSourcingProjectStatusManager;
    }

    public function getAllCrowdSourcingProjects()
    {
        return $this->crowdSourcingProjectRepository->all();
    }

    public function getCrowdSourcingProject($id = self::DEFAULT_PROJECT_ID)
    {
        return $this->crowdSourcingProjectRepository->find($id);
    }

    public function getCrowdSourcingProjectBySlug($project_slug) {
        return $this->crowdSourcingProjectRepository->findBy('slug', $project_slug);
    }

    public function getCrowdSourcingProjectViewModelForLandingPage($questionnaireId, $openQuestionnaireWhenPageLoads, $project_slug) {
        $project = $this->getCrowdSourcingProjectBySlug($project_slug);
        if(!$project)
            throw new ResourceNotFoundException("Project not found");

        $questionnaire = null;
        $userResponse = null;
        $allResponses = collect([]);
        $allLanguagesForQuestionnaire = collect([]);

        if($questionnaireId)
            $questionnaire = $this->questionnaireRepository->findQuestionnaire($questionnaireId);
        else
            $questionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject($project->id, Auth::id());

        if ($questionnaire) {
            $userResponse = $this->questionnaireRepository->getUserResponseForQuestionnaire($questionnaire->id, Auth::id());
            $allResponses = $this->questionnaireRepository->getAllResponsesForQuestionnaire($questionnaire->id);
            $allLanguagesForQuestionnaire = $this->questionnaireTranslationRepository->getAvailableLanguagesForQuestionnaire($questionnaire);
            if ($userResponse!=null)
                $openQuestionnaireWhenPageLoads = false; //user has already responded
        }

        $projectGoalVM = $this->getCrowdSourcingProjectGoalViewModel($project->id);
        return new CrowdSourcingProjectForLandingPage($project, $questionnaire,
            $userResponse,
            $allResponses,
            $allLanguagesForQuestionnaire,
            $openQuestionnaireWhenPageLoads,
            $projectGoalVM);
    }

    public function getCrowdSourcingProjectGoalViewModel($projectId) {
        $questionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject($projectId, Auth::id());
        if(!$questionnaire)
            return null;

        $allResponses = $this->questionnaireRepository->getAllResponsesForQuestionnaire($questionnaire->id);
        $responsesNeededToReachGoal = $questionnaire->goal - $allResponses->count();
        $targetAchievedPercentage = round($allResponses->count() / $questionnaire->goal * 100, 1);
        $goal = $questionnaire->goal;

        return new CrowdSourcingProjectGoal($responsesNeededToReachGoal, $targetAchievedPercentage, $goal);
    }

    public function createProject(array $attributes) {
        if (isset($attributes['logo'])) {
            $attributes['logo_path'] = FileUploader::uploadAndGetPath($attributes['logo'], 'project_logos');
        }
        if (isset($attributes['img'])) {
            $attributes['img_path'] = FileUploader::uploadAndGetPath($attributes['img'], 'project_img');
        }

        if(! isset($attributes['slug'])) {
            $attributes['slug'] = Str::slug($attributes['name'], '-');
        }

        $attributes['user_creator_id'] = Auth::id();

        return $this->crowdSourcingProjectRepository->create($attributes);

    }

    public function updateCrowdSourcingProject($id, array $attributes) {

        if (isset($attributes['logo'])) {
            $attributes['logo_path'] = FileUploader::uploadAndGetPath($attributes['logo'], 'project_logos');
        }
        if (isset($attributes['img'])) {
            $attributes['img_path'] = FileUploader::uploadAndGetPath($attributes['img'], 'project_img');
        }

        return $this->crowdSourcingProjectRepository->update($attributes, $id);
    }

    public function getActiveQuestionnaireForProject($projectId = self::DEFAULT_PROJECT_ID) {
        return $this->questionnaireRepository->getActiveQuestionnaireForProject($projectId, Auth::id());
    }

    public function getCrowdSourcingProjectReportsViewModel($selectedProjectId = null, $selectedQuestionnaireId = null) {
        $allProjects = $this->getAllCrowdSourcingProjects();
        $allQuestionnaires = $this->questionnaireRepository->getAllQuestionnaires();
        return new QuestionnaireReportFilters($allProjects, $allQuestionnaires, $selectedProjectId, $selectedQuestionnaireId);
    }

    public function getDefaultCrowdsourcingProject() {
        return $this->getCrowdSourcingProject(self::DEFAULT_PROJECT_ID);
    }

    // TODO this method should return only the active projects
    public function getAllActiveCrowdSourcingProjects() {
        return $this->getAllCrowdSourcingProjects();
    }

    public function getCreateProjectViewModel() {
        return new CreateEditCrowdSourcingProject($this->crowdSourcingProjectRepository->getModelInstance(),
            $this->crowdSourcingProjectStatusManager->getAllCrowdSourcingProjectStatusesLkp());
    }

    public function getEditProjectViewModel(int $id) {
        return new CreateEditCrowdSourcingProject($this->getCrowdSourcingProject($id),
            $this->crowdSourcingProjectStatusManager->getAllCrowdSourcingProjectStatusesLkp());
    }

    public function shouldShowLandingPage($project_slug) {
        $project = $this->getCrowdSourcingProjectBySlug($project_slug);
        return $project->status_id === CrowdSourcingProjectStatusLkp::PUBLISHED ||
            $project->status_id === CrowdSourcingProjectStatusLkp::FINALIZED;
    }

    public function getCrowdSourcingProjectUnavailableViewModel($project_slug) {
        $project = $this->getCrowdSourcingProjectBySlug($project_slug);
        switch ($project->status_id) {
            case CrowdSourcingProjectStatusLkp::DRAFT:
                $unavailabilityMessage = 'The project is still in the draft phase.';
                break;
            case CrowdSourcingProjectStatusLkp::UNPUBLISHED:
                $unavailabilityMessage = 'The project is unpublished';
                break;
            case CrowdSourcingProjectStatusLkp::DELETED:
                $unavailabilityMessage = 'The project is deleted';
                break;
            default:
                throw new \Exception('The project status could not be identified: ' . $project->status_id);
        }
        return new CrowdSourcingProjectUnavailable($project, $unavailabilityMessage);
    }
}
