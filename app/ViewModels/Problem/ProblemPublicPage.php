<?php

namespace App\ViewModels\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Problem\Problem;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectLayoutPage;

class ProblemPublicPage extends CrowdSourcingProjectLayoutPage {
    public string $page_title;

    public function __construct(public Problem $problem, CrowdSourcingProject $project) {
        parent::__construct($project);
        $this->page_title = $project->currentTranslation->name . ' | ' . $this->problem->currentTranslation->title;
    }
}
