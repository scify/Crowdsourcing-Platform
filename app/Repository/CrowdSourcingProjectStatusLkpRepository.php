<?php

namespace App\Repository;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusLkp;

class CrowdSourcingProjectStatusLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return CrowdSourcingProjectStatusLkp::class;
    }
}
