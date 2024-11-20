<?php

namespace App\Repository\Problem;

use App\Models\Problem\CrowdSourcingProjectProblemStatusLkp;
use App\Repository\Repository;

class CrowdSourcingProjectProblemStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return CrowdSourcingProjectProblemStatusLkp::class;
    }
}
