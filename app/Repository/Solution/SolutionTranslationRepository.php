<?php

namespace App\Repository\Solution;

use App\Models\Solution\SolutionTranslation;
use App\Repository\Repository;

class SolutionTranslationRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return SolutionTranslation::class;
    }
}
