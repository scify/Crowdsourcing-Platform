<?php

namespace App\ViewModels\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;

class CrowdSourcingProjectProblemsLandingPage {
    public CrowdSourcingProject $project;

    public function __construct(CrowdSourcingProject $crowdSourcingProject) {
        $this->project = $crowdSourcingProject;
    }
}
