<?php

namespace App\ViewModels\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Problem\Problem;

class ProblemPublicPage {
    public Problem $problem;
    public CrowdSourcingProject $project;
    public string $page_title;

    public function __construct(Problem $problem, CrowdSourcingProject $project) {
        $this->problem = $problem;
        $this->project = $project;
        $this->page_title = $project->currentTranslation->name . ' | ' . $problem->currentTranslation->title;
    }
}
