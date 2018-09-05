<?php

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\CrowdSourcingProjectForLandingPage;
use App\Models\ViewModels\CrowdSourcingProjectGoal;
use App\Models\ViewModels\CrowdSourcingProjectReport;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\QuestionnaireRepository;
use Illuminate\Support\Facades\Auth;

class CrowdSourcingProjectManager
{
    private $crowdSourcingProjectRepository;
    private $questionnaireRepository;
    const DEFAULT_PROJECT_ID = 1;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
                                QuestionnaireRepository $questionnaireRepository)
    {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->questionnaireRepository = $questionnaireRepository;
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
        $questionnaire = null;
        $userResponse = null;
        $allResponses = collect([]);
        $allLanguagesForQuestionnaire = collect([]);
        if ($project)
            $questionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject($project->id);
        if ($questionnaire) {
            $userResponse = $this->questionnaireRepository->getUserResponseForQuestionnaire($questionnaire->id, Auth::id());
            if ($userResponse!=null)
                $openQuestionnaireWhenPageLoads = false; //user has already responded
            $allResponses = $this->questionnaireRepository->getAllResponsesForQuestionnaire($questionnaire->id);
            $allLanguagesForQuestionnaire = $this->questionnaireRepository->getAvailableLanguagesForQuestionnaire($questionnaire);
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
        $questionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject($projectId);
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

    public function projectHasActiveQuestionnaire($projectId = self::DEFAULT_PROJECT_ID) {
        return $this->questionnaireRepository->getActiveQuestionnaireForProject($projectId) !== null;
    }

    public function getActiveQuestionnaireForProject($projectId = self::DEFAULT_PROJECT_ID) {
        return $this->questionnaireRepository->getActiveQuestionnaireForProject($projectId);
    }

    public function userHasAlreadyAnsweredTheActiveQuestionnaire($userId, $projectId = self::DEFAULT_PROJECT_ID) {
        $activeQuestionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject($projectId);
        if(!$activeQuestionnaire)
            return false;
        $userResponse = $this->questionnaireRepository->getUserResponseForQuestionnaire($activeQuestionnaire->id, $userId);
        return $userResponse !== null;
    }

    public function getCrowdSourcingProjectReportsViewModel($selectedProjectId = null, $selectedQuestionnaireId = null) {
        $allProjects = $this->getAllCrowdSourcingProjects();
        $allQuestionnaires = $this->questionnaireRepository->getAllQuestionnaires();
        return new CrowdSourcingProjectReport($allProjects, $allQuestionnaires, $selectedProjectId, $selectedQuestionnaireId);
    }
}