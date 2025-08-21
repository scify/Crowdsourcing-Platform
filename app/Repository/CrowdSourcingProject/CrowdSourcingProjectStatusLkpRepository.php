<?php

declare(strict_types=1);

namespace App\Repository\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusLkp;
use App\Repository\Repository;

class CrowdSourcingProjectStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return CrowdSourcingProjectStatusLkp::class;
    }
}
