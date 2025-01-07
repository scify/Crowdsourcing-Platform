<?php

namespace App\ViewModels\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Support\Collection;

class CrowdSourcingProjectUnavailable extends CrowdSourcingProjectLayoutPage {
    /**
     * @var \Illuminate\Support\Collection
     */
    public $projects;

    /**
     * @var string
     */
    public $statusMessage;

    public function __construct(CrowdSourcingProject $project, Collection $projects, string $statusMessage) {
        parent::__construct($project);
        $this->projects = $projects;
        $this->statusMessage = $statusMessage;
    }

    public function getProjectStatusMessage(): string {
        return $this->statusMessage;
    }
}
