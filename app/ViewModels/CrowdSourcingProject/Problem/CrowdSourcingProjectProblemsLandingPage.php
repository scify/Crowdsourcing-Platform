<?php

namespace App\ViewModels\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Support\Collection;

class CrowdSourcingProjectProblemsLandingPage {
    public CrowdSourcingProject $project;
    public Collection $crowdSourcingProjectProblems;

    public function __construct(CrowdSourcingProject $crowdSourcingProject, Collection $crowdSourcingProjectProblems) {
        $this->project = $crowdSourcingProject;
        $this->crowdSourcingProjectProblems = $crowdSourcingProjectProblems;
    }
}
