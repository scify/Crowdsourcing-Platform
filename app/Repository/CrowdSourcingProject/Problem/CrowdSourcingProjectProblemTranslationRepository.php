<?php

namespace App\Repository\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\Repository;

class CrowdSourcingProjectProblemTranslationRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return CrowdSourcingProjectProblemTranslation::class;
    }
}
