<?php


namespace App\Repository;


use App\Models\CrowdSourcingProjectStatusLkp;

class CrowdSourcingProjectStatusLkpRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return CrowdSourcingProjectStatusLkp::class;
    }
}
