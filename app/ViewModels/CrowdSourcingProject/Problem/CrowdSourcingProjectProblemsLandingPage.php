<?php

namespace App\ViewModels\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Support\Collection;

class CrowdSourcingProjectProblemsLandingPage {
    public CrowdSourcingProject $crowdSourcingProject;
    public Collection $crowdSourcingProjectProblems;

    public function __construct(CrowdSourcingProject $crowdSourcingProject, Collection $crowdSourcingProjectProblems) {
        $this->crowdSourcingProject = $crowdSourcingProject;
        $this->crowdSourcingProjectProblems = $crowdSourcingProjectProblems;
    }
}
