<?php

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\CrowdSourcingProjectForLandingPage;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\QuestionnaireRepository;
use Illuminate\Support\Facades\Auth;

class CrowdSourcingProjectManager
{
    private $crowdSourcingProjectRepository;
    private $questionnaireRepository;

    /**
     * CrowdSourcingProjectManager constructor.
     * @param CrowdSourcingProjectRepository $crowdSourcingProjectRepository
     * @param QuestionnaireRepository $questionnaireRepository
     */
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

//    public function getAllCrowdSourcingProjectsViewModels()
//    {
//        $projects = $this->crowdSourcingProjectRepository->all();
//        $projectsViewModel = $projects->map(function ($project) {
//            return new CrowdSourcingProject($project);
//        });
//        return new CrowdSourcingProjects($projectsViewModel);
//    }

    public function getCrowdSourcingProject($id)
    {
        return $this->crowdSourcingProjectRepository->find($id);
    }

    public function getCrowdSourcingProjectBySlug($project_slug) {
        return $this->crowdSourcingProjectRepository->findBy('slug', $project_slug);
    }

    public function getCrowdSourcingProjectViewModelForLandingPage($openQuestionnaireWhenPageLoads,$project_slug) {
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
        return new CrowdSourcingProjectForLandingPage($project, $questionnaire,
            $userResponse,
            $allResponses,
            $allLanguagesForQuestionnaire,
            $openQuestionnaireWhenPageLoads);
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
}