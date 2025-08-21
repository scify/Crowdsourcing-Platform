<?php

declare(strict_types=1);

namespace App\Repository\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusHistory;
use App\Repository\Repository;

class CrowdSourcingProjectStatusHistoryRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function getModelClassName(): string {
        return CrowdSourcingProjectStatusHistory::class;
    }
}
