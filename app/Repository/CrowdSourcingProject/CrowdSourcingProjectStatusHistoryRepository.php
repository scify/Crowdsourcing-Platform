<?php

namespace App\Repository\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusHistory;
use App\Repository\Repository;

class CrowdSourcingProjectStatusHistoryRepository extends Repository {
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function getModelClassName() {
        return CrowdSourcingProjectStatusHistory::class;
    }
}
