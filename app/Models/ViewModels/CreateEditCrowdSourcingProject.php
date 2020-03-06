<?php


namespace App\Models\ViewModels;


use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class CreateEditCrowdSourcingProject {

    public $project;
    public $projectStatusesLkp;
    public $contributorEmailView;

    public function __construct(\App\Models\CrowdSourcingProject $project, Collection $projectStatusesLkp, string $contributorEmailView) {
        $this->project = $project;
        $this->projectStatusesLkp = $projectStatusesLkp;
        $this->contributorEmailView = $contributorEmailView;
    }

    public function isEditMode() {
        return $this->project->id !== null;
    }

}
