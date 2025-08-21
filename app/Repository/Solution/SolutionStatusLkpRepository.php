<?php

declare(strict_types=1);

namespace App\Repository\Solution;

use App\Models\Solution\SolutionStatusLkp;
use App\Repository\Repository;

class SolutionStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return SolutionStatusLkp::class;
    }
}
