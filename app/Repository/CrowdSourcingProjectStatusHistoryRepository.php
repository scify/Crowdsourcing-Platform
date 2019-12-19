<?php

namespace App\Repository;

use App\Models\CrowdSourcingProjectStatusHistory;

class CrowdSourcingProjectStatusHistoryRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName()
    {
        return CrowdSourcingProjectStatusHistory::class;
    }
}
