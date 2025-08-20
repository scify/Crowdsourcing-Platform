<?php

declare(strict_types=1);

namespace App\Repository\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Repository\Repository;

class CrowdSourcingProjectTranslationRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return CrowdSourcingProjectTranslation::class;
    }
}
