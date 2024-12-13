<?php

namespace App\Repository\Solution;

use App\Models\Solution\SolutionShare;
use App\Repository\Repository;

class SolutionShareRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return SolutionShare::class;
    }
}
