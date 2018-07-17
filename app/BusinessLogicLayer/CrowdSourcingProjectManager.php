<?php

namespace App\BusinessLogicLayer;

use App\DataAccessLayer\QuestionnaireStorageManager;
use App\Models\ViewModels\CrowdSourcingProjectForLandingPage;
use App\Repository\CrowdSourcingProjectRepository;

class CrowdSourcingProjectManager
{
    private $crowdSourcingProjectRepository;
    private $questionnaireStorageManager;

    /**
     * CrowdSourcingProjectManager constructor.
     * @param CrowdSourcingProjectRepository $crowdSourcingProjectRepository
     * @param QuestionnaireStorageManager $questionnaireStorageManager
     */
    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
                                QuestionnaireStorageManager $questionnaireStorageManager)
    {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->questionnaireStorageManager = $questionnaireStorageManager;
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

    public function getCrowdSourcingProjectViewModelForLandingPage($project_slug) {
        $project = $this->getCrowdSourcingProjectBySlug($project_slug);
        $questionnaire = null;
        $questionnaireResponse = null;
        if ($project)
            $questionnaire = $this->questionnaireStorageManager->getActiveQuestionnaireForProject($project->id);
        if ($questionnaire)
            $questionnaireResponse =  $this->questionnaireStorageManager->getResponseForQuestionnaire($questionnaire->id);
        return new CrowdSourcingProjectForLandingPage($project, $questionnaire, $questionnaireResponse);
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