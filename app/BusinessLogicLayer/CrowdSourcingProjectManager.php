<?php

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\CrowdSourcingProject;
use App\Models\ViewModels\CrowdSourcingProjects;
use App\Repository\CrowdSourcingProjectRepository;
use Illuminate\Support\Facades\Storage;

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