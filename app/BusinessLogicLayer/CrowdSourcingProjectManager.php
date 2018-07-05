<?php

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\CrowdSourcingProject;
use App\Models\ViewModels\CrowdSourcingProjects;
use App\Repository\CrowdSourcingProjectRepository;

class CrowdSourcingProjectManager
{
    private $crowdSourcingProjectRepository;

    /**
     * CrowdSourcingProjectManager constructor.
     * @param $crowdSourcingProjectRepository
     */
    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository)
    {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
    }

    public function getAllCrowdSourcingProjects()
    {
        return $this->crowdSourcingProjectRepository->all();
    }

    public function getAllCrowdSourcingProjectsViewModels()
    {
        $projects = $this->crowdSourcingProjectRepository->all();
        $projectsViewModel = $projects->map(function ($article) {
            return new CrowdSourcingProject($article);
        });
        return new CrowdSourcingProjects($projectsViewModel);
    }

    public function getCrowdSourcingProject($id)
    {
        return $this->crowdSourcingProjectRepository->find($id);
    }
}