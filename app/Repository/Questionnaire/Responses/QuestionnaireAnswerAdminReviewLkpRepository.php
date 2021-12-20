<?php

namespace App\Repository\Questionnaire\Responses;

use App\Models\Questionnaire\QuestionnaireAnswerAdminReviewLkp;
use App\Repository\Repository;

class QuestionnaireAnswerAdminReviewLkpRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return QuestionnaireAnswerAdminReviewLkp::class;
    }
}
