<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemStatusLkpRepository;

class CrowdSourcingProjectProblemStatusManager {
    protected $crowdSourcingProjectProblemStatusLkpRepository;

    public function __construct(CrowdSourcingProjectProblemStatusLkpRepository $crowdSourcingProjectProblemStatusLkpRepository) {
        $this->crowdSourcingProjectProblemStatusLkpRepository = $crowdSourcingProjectProblemStatusLkpRepository;
    }

    public function getAllCrowdSourcingProjectProblemStatusesLkp() {
        return $this->crowdSourcingProjectProblemStatusLkpRepository->all();
    }
}
