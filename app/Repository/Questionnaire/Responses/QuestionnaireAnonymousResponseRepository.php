<?php

namespace App\Repository\Questionnaire\Responses;

use App\Models\Questionnaire\QuestionnaireAnonymousResponse;
use App\Repository\Repository;

class QuestionnaireAnonymousResponseRepository extends Repository {

    /**
     * @inheritDoc
     */
    public function getModelClassName() {
        return QuestionnaireAnonymousResponse::class;
    }
}