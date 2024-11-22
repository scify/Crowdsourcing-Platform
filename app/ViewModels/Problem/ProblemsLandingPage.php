<?php

namespace App\ViewModels\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;

class ProblemsLandingPage {
    public CrowdSourcingProject $project;

    public function __construct(CrowdSourcingProject $crowdSourcingProject) {
        $this->project = $crowdSourcingProject;
    }
}
