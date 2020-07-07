<?php


namespace App\Models\ViewModels\Questionnaire;

use App\Models\CrowdSourcingProject;

class QuestionnaireVisualizations {
    public $project;

    public function __construct(CrowdSourcingProject $project) {
        $this->project = $project;
    }

}
