<?php

namespace App\ViewModels\Solution;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Problem\Problem;
use App\Models\Solution\Solution;

class SolutionSubmitted {
    public Solution $solution;
    public Problem $problem;
    public CrowdSourcingProject $project;
    public string $page_title;

    public function __construct(Solution $solution, Problem $problem, CrowdSourcingProject $project) {
        $this->solution = $solution;
        $this->problem = $problem;
        $this->project = $project;
        $this->page_title = $project->currentTranslation->name . ' | ' . $problem->currentTranslation->title . ' ➔ ' . __('solution.proposal_submitted_title');
    }
}
