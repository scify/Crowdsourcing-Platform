<?php

namespace App\Repository\Questionnaire\Responses;

use App\Models\Questionnaire\QuestionnaireResponseToxicity;
use App\Repository\Repository;

class QuestionnaireResponseToxicityRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return QuestionnaireResponseToxicity::class;
    }
}
