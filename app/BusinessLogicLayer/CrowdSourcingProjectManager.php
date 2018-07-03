<?php

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\CrowdSourcingProject;
use App\Models\ViewModels\CrowdSourcingProjects;
use App\Repository\CrowdSourcingProjectRepository;

class CrowdSourcingProjectManager {

    private $DEFAULT_PROJECT_ID = 1;
    private $crowdSourcingProjectRepository;

    /**
     * CrowdSourcingProjectManager constructor.
     * @param $crowdSourcingProjectRepository
     */
    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository) {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
    }

    public function getDefaultCrowdSourcingProject() {
        return $this->crowdSourcingProjectRepository->find($this->DEFAULT_PROJECT_ID);
    }

    public function getAllCrowdSourcingProjects() {
        return $this->crowdSourcingProjectRepository->all();
    }

    public function getAllCrowdSourcingProjectsViewModels() {
        $projects = $this->crowdSourcingProjectRepository->all();
        $projectsViewModel = $projects->map(function ($article) {
            return new CrowdSourcingProject($article);
        });
        return new CrowdSourcingProjects($projectsViewModel);
    }
}