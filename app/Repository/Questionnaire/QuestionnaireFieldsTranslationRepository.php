<?php

namespace App\Repository\Questionnaire;

use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\Repository\Repository;

class QuestionnaireFieldsTranslationRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return QuestionnaireFieldsTranslation::class;
    }
}
