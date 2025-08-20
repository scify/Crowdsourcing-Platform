<?php

declare(strict_types=1);

namespace App\Repository\Problem;

use App\Models\Problem\ProblemStatusLkp;
use App\Repository\Repository;

class ProblemStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return ProblemStatusLkp::class;
    }
}
