<?php


namespace App\Models\ViewModels\Questionnaire;

use App\Models\CrowdSourcingProject;

class QuestionnaireVisualizations {
    public $project;
    public $home_url;

    public function __construct(CrowdSourcingProject $project) {
        $this->project = $project;
        $this->home_url = route('project.landing-page', $project->slug);
    }

}
