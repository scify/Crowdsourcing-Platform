<?php

namespace App\ViewModels\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;

class CreateEditProblem {
    public CrowdSourcingProjectProblem $crowdSourcingProjectProblem;
    public function __construct(CrowdSourcingProjectProblem $crowdSourcingProjectProblem) {
        $this->crowdSourcingProjectProblem = $crowdSourcingProjectProblem;
    }

}