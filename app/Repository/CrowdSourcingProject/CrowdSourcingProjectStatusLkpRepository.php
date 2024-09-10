<?php

namespace App\Repository\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusLkp;
use App\Repository\Repository;

class CrowdSourcingProjectStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return CrowdSourcingProjectStatusLkp::class;
    }
}
