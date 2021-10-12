<?php


namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class CrowdSourcingProjectUnavailable {

    public $project;
    public $projects;
    public $statusMessage;

    public function __construct(\App\Models\CrowdSourcingProject\CrowdSourcingProject $project, Collection $projects, string $statusMessage) {
        $this->project = $project;
        $this->projects = $projects;
        $this->statusMessage = $statusMessage;
    }

    public function getProjectStatusMessage() {
        return $this->statusMessage;
    }

}
