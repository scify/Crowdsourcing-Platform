<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Solution;

use App\Repository\Solution\SolutionStatusLkpRepository;

class SolutionStatusManager {
    public function __construct(protected SolutionStatusLkpRepository $solutionStatusLkpRepository) {}

    public function getAllSolutionStatusesLkp() {
        return $this->solutionStatusLkpRepository->all();
    }
}
