<?php

namespace App\Repository\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Repository\Repository;

class CrowdSourcingProjectTranslationRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return CrowdSourcingProjectTranslation::class;
    }
}
