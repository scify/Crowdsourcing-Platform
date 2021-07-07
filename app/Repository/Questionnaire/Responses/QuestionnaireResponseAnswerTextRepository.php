<?php


namespace App\Repository\Questionnaire\Responses;


use App\Models\QuestionnaireResponseAnswerText;
use App\Repository\Repository;

class QuestionnaireResponseAnswerTextRepository extends Repository {

    function getModelClassName() {
        return QuestionnaireResponseAnswerText::class;
    }
}
