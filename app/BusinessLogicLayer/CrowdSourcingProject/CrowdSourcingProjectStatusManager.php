<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\Repository\CrowdSourcingProject\CrowdSourcingProjectStatusLkpRepository;

class CrowdSourcingProjectStatusManager {
    public function __construct(protected CrowdSourcingProjectStatusLkpRepository $crowdSourcingProjectStatusRepository) {}

    public function getAllCrowdSourcingProjectStatusesLkp() {
        return $this->crowdSourcingProjectStatusRepository->all();
    }
}
