<?php

namespace App\BusinessLogicLayer\Problem;

use App\Repository\Problem\ProblemStatusLkpRepository;

class ProblemStatusManager {
    protected ProblemStatusLkpRepository $problemStatusLkpRepository;

    public function __construct(ProblemStatusLkpRepository $problemStatusLkpRepository) {
        $this->problemStatusLkpRepository = $problemStatusLkpRepository;
    }

    public function getAllProblemStatusesLkp() {
        return $this->problemStatusLkpRepository->all();
    }
}
