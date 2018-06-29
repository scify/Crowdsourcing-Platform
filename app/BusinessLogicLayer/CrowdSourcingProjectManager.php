<?php

namespace App\BusinessLogicLayer;

use App\Repository\CrowdSourcingProjectRepository;

class CrowdSourcingProjectManager {

    private $DEFAULT_PROJECT_ID = 1;
    private $crowdSourcingProjectRepository;

    /**
     * CrowdSourcingProjectManager constructor.
     * @param $crowdSourcingProjectRepository
     */
    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository) {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
    }

    public function getDefaultCrowdSourcingProject() {
        return $this->crowdSourcingProjectRepository->find($this->DEFAULT_PROJECT_ID);
    }
}