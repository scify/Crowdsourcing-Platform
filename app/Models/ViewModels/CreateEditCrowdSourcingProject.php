<?php


namespace App\Models\ViewModels;


use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Support\Collection;

class CreateEditCrowdSourcingProject {

    public $project;
    public $projectStatusesLkp;
    public $contributorEmailView;

    public function __construct(CrowdSourcingProject $project, Collection $projectStatusesLkp, string $contributorEmailView) {
        $this->project = $project;
        $this->projectStatusesLkp = $projectStatusesLkp;
        $this->contributorEmailView = $contributorEmailView;
    }

    public function isEditMode(): bool {
        return $this->project->id !== null;
    }

}
