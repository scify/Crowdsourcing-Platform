<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Problem;

use App\Repository\Problem\ProblemStatusLkpRepository;

class ProblemStatusManager {
    public function __construct(protected ProblemStatusLkpRepository $problemStatusLkpRepository) {}

    public function getAllProblemStatusesLkp() {
        return $this->problemStatusLkpRepository->all();
    }
}
