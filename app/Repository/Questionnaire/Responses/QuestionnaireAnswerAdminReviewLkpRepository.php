<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Responses;

use App\Models\Questionnaire\QuestionnaireAnswerAdminReviewLkp;
use App\Repository\Repository;

class QuestionnaireAnswerAdminReviewLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return QuestionnaireAnswerAdminReviewLkp::class;
    }
}
