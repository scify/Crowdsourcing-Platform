<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\Repository\CrowdSourcingProject\CrowdSourcingProjectStatusLkpRepository;

class CrowdSourcingProjectStatusManager {
    protected $crowdSourcingProjectStatusRepository;

    public function __construct(CrowdSourcingProjectStatusLkpRepository $crowdSourcingProjectStatusRepository) {
        $this->crowdSourcingProjectStatusRepository = $crowdSourcingProjectStatusRepository;
    }

    public function getAllCrowdSourcingProjectStatusesLkp() {
        return $this->crowdSourcingProjectStatusRepository->all();
    }
}
