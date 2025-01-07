<?php

namespace App\ViewModels\Solution;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Problem\Problem;
use App\Models\Solution\Solution;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectLayoutPage;

class SolutionSubmitted extends CrowdSourcingProjectLayoutPage {
    public string $page_title;

    public function __construct(public Solution $solution, public Problem $problem, CrowdSourcingProject $project) {
        parent::__construct($project);
        $this->page_title = $project->currentTranslation->name . ' | ' . $this->problem->currentTranslation->title . ' ➔ ' . __('solution.proposal_submitted_title');
    }
}
