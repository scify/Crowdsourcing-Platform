<?php


namespace App\Models\ViewModels;


class CreateEditCrowdSourcingProject {

    public $project;

    /**
     * CreateEditCrowdSourcingProject constructor.
     * @param $project
     */
    public function __construct(\App\Models\CrowdSourcingProject $project) {
        $this->project = $project;
    }

    public function isEditMode() {
        return $this->project->id !== null;
    }

}
