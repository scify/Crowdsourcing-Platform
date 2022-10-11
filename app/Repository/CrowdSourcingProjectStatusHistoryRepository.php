<?php

namespace App\Repository;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusHistory;

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
