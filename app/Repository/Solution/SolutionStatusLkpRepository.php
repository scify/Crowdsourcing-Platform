<?php

namespace App\Repository\Solution;

use App\Models\Solution\SolutionStatusLkp;
use App\Repository\Repository;

class SolutionStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return SolutionStatusLkp::class;
    }
}
