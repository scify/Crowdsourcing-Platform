<?php

namespace App\Repository;


use App\Models\QuestionnaireResponseAnswerText;

class QuestionnaireResponseAnswerRepository {

    public function getNonTranslatedAnswers() {
        return QuestionnaireResponseAnswerText::where(['english_translation' => null])->get();
    }
}