<?php

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\CrowdSourcingProjectForLandingPage;
use App\Models\ViewModels\CrowdSourcingProjectGoal;
use App\Models\ViewModels\reports\QuestionnaireReportFilters;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireTranslationRepository;
use Illuminate\Support\Facades\Auth;
use JsonSchema\Exception\ResourceNotFoundException;

define('DEFAULT_PROJECT_ID', config('app.project_id'));

class CrowdSourcingProjectManager
{
    private $crowdSourcingProjectRepository;
    private $questionnaireRepository;
    private $questionnaireTranslationRepository;
    const DEFAULT_PROJECT_ID = DEFAULT_PROJECT_ID;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
                                QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireTranslationRepository $questionnaireTranslationRepository)
    {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
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

    public function getCrowdSourcingProjectViewModelForLandingPage($openQuestionnaireWhenPageLoads, $project_slug) {
        $project = $this->getCrowdSourcingProjectBySlug($project_slug);
        if(!$project)
            throw new ResourceNotFoundException("Project not found");

        $questionnaire = null;
        $userResponse = null;
        $allResponses = collect([]);
        $allLanguagesForQuestionnaire = collect([]);

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


    public function updateCrowdSourcingProject($id, $attributes)
    {
        unset($attributes['_token']);
        if (isset($attributes['logo'])) {
            $path = $attributes['logo']->store('project_' . $id, 'projects');
            $attributes['logo_path'] = '/storage/projects/' . $path;
            unset($attributes['logo']);
        }
        if (isset($attributes['img'])) {
            $path = $attributes['img']->store('project_' . $id, 'projects');
            $attributes['img_path'] = '/storage/projects/' . $path;
            unset($attributes['img']);
        }
        $this->crowdSourcingProjectRepository->update($attributes, $id);
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
}