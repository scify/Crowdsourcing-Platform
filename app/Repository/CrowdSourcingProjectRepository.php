<?php

namespace App\Repository;


use App\Models\CrowdSourcingProject;

class CrowdSourcingProjectRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName()
    {
        return CrowdSourcingProject::class;
    }

}