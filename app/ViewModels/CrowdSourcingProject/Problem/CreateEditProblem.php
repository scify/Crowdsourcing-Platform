<?php

namespace App\ViewModels\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;

class CreateEditProblem {
    public CrowdSourcingProjectProblem $problem;

    public function __construct(CrowdSourcingProjectProblem $crowdSourcingProjectProblem) {
        $this->problem = $crowdSourcingProjectProblem;
    }

    public function isEditMode(): bool {
        return $this->problem->id !== null;
    }
}
