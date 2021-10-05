<?php

namespace App\Repository\Questionnaire;

use App\Models\Questionnaire\QuestionnaireLanguage;

class QuestionnaireTranslationRepository {

    public function getQuestionnaireLanguage($questionnaireId, $langId) {
        return QuestionnaireLanguage::where(['questionnaire_id' => $questionnaireId, 'language_id' => $langId])->first();
    }
}
