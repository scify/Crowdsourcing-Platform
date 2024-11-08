<?php

namespace App\Repository\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemStatusLkp;
use App\Repository\Repository;

class CrowdSourcingProjectProblemStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return CrowdSourcingProjectProblemStatusLkp::class;
    }
}
