<?php

namespace App\Repository\Problem;

use App\Models\Problem\ProblemStatusLkp;
use App\Repository\Repository;

class ProblemStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return ProblemStatusLkp::class;
    }
}
