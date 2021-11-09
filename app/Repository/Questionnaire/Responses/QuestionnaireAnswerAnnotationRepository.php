<?php

namespace App\Repository\Questionnaire\Responses;

use App\Models\Questionnaire\QuestionnaireAnswerAnnotation;
use App\Repository\Repository;
use Illuminate\Support\Collection;

class QuestionnaireAnswerAnnotationRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return QuestionnaireAnswerAnnotation::class;
    }

    public function getAnswerAnnotationsForQuestionnaireAnswers(int $questionnaire_id): Collection {
        return QuestionnaireAnswerAnnotation::where([
            'questionnaire_id' => $questionnaire_id
        ])->get()->groupBy(['question_name', 'respondent_user_id']);
    }
}
