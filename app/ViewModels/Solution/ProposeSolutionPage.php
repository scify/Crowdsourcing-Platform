<?php

namespace App\ViewModels\Solution;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Language;
use App\Models\Problem\Problem;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectLayoutPage;

class ProposeSolutionPage extends CrowdSourcingProjectLayoutPage {
    public Problem $problem;
    public Language $language;
    public string $page_title;

    public function __construct(
        CrowdSourcingProject $project,
        Problem $problem,
        Language $language,
    ) {
        parent::__construct($project);
        $this->problem = $problem;
        $this->language = $language;
        $this->page_title = $project->currentTranslation->name . ' | ' . $problem->currentTranslation->title . ' ➔ ' . __('solution.propose_solution');
    }
}
