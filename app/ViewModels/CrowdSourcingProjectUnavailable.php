<?php

namespace App\ViewModels;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Support\Collection;

class CrowdSourcingProjectUnavailable {
    public $project;
    public $projects;
    public $statusMessage;

    public function __construct(CrowdSourcingProject $project, Collection $projects, string $statusMessage) {
        $this->project = $project;
        $this->projects = $projects;
        $this->statusMessage = $statusMessage;
    }

    public function getProjectStatusMessage() {
        return $this->statusMessage;
    }
}
