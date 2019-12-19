<?php


namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class CreateEditCrowdSourcingProject {

    public $project;
    public $projectStatusesLkp;

    public function __construct(\App\Models\CrowdSourcingProject $project, Collection $projectStatusesLkp) {
        $this->project = $project;
        $this->projectStatusesLkp = $projectStatusesLkp;
    }

    public function isEditMode() {
        return $this->project->id !== null;
    }

}
