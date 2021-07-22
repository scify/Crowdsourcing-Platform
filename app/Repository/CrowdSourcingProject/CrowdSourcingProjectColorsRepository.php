<?php


namespace App\Repository\CrowdSourcingProject;


use App\Models\CrowdSourcingProject\CrowdSourcingProjectColors;
use App\Repository\Repository;

class CrowdSourcingProjectColorsRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return CrowdSourcingProjectColors::class;
    }
}
