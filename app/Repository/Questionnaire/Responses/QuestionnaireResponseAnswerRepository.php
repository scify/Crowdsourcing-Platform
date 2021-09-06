<?php

namespace App\Repository\Questionnaire\Responses;


use App\Models\QuestionnaireResponseAnswerText;

class QuestionnaireResponseAnswerRepository {

    public function getNonTranslatedAnswers() {
        return QuestionnaireResponseAnswerText::
            where(['english_translation' => null, 'parsed' => false])
            ->get();
    }
}
