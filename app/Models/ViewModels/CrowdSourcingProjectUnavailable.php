<?php


namespace App\Models\ViewModels;


class CrowdSourcingProjectUnavailable {

    public $project;
    public $statusMessage;

    public function __construct(\App\Models\CrowdSourcingProject $project, string $statusMessage) {
        $this->project = $project;
        $this->statusMessage = $statusMessage;
    }

    public function getProjectStatusMessage() {
        return $this->statusMessage;
    }

}
