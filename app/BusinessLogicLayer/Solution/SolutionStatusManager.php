<?php

namespace App\BusinessLogicLayer\Solution;

use App\Repository\Solution\SolutionStatusLkpRepository;

class SolutionStatusManager {
    protected SolutionStatusLkpRepository $solutionStatusLkpRepository;

    public function __construct(SolutionStatusLkpRepository $solutionStatusLkpRepository) {
        $this->solutionStatusLkpRepository = $solutionStatusLkpRepository;
    }

    public function getAllSolutionStatusesLkp() {
        return $this->solutionStatusLkpRepository->all();
    }
}
