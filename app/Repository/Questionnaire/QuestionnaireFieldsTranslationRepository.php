<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire;

use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\Repository\Repository;

class QuestionnaireFieldsTranslationRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return QuestionnaireFieldsTranslation::class;
    }
}
