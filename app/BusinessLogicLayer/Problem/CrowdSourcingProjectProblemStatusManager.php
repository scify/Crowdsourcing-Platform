<?php

namespace App\BusinessLogicLayer\Problem;

use App\Repository\Problem\CrowdSourcingProjectProblemStatusLkpRepository;

class CrowdSourcingProjectProblemStatusManager {
    protected CrowdSourcingProjectProblemStatusLkpRepository $crowdSourcingProjectProblemStatusLkpRepository;

    public function __construct(CrowdSourcingProjectProblemStatusLkpRepository $crowdSourcingProjectProblemStatusLkpRepository) {
        $this->crowdSourcingProjectProblemStatusLkpRepository = $crowdSourcingProjectProblemStatusLkpRepository;
    }

    public function getAllCrowdSourcingProjectProblemStatusesLkp() {
        return $this->crowdSourcingProjectProblemStatusLkpRepository->all();
    }
}
