<?php

namespace App\Repository\Solution;

use App\Models\Solution\Solution;
use App\Repository\Repository;

class SolutionRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return Solution::class;
    }
}
