<?php

namespace App\ViewModels\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Problem\Problem;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectLayoutPage;

class ProblemPublicPage extends CrowdSourcingProjectLayoutPage {
    public Problem $problem;
    public string $page_title;

    public function __construct(Problem $problem, CrowdSourcingProject $project) {
        parent::__construct($project);
        $this->problem = $problem;
        $this->page_title = $project->currentTranslation->name . ' | ' . $problem->currentTranslation->title;
    }
}
