<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Responses;

use App\Models\Questionnaire\QuestionnaireResponseToxicity;
use App\Repository\Repository;

class QuestionnaireResponseToxicityRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return QuestionnaireResponseToxicity::class;
    }
}
