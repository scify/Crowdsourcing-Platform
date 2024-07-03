<?php

namespace App\Repository\Questionnaire;

use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\Models\Questionnaire\QuestionnaireLanguage;
use App\Repository\Repository;

class QuestionnaireTranslationRepository extends Repository {
    public function getModelClassName() {
        return QuestionnaireFieldsTranslation::class;
    }

    public function getQuestionnaireLanguage($questionnaireId, $langId): QuestionnaireLanguage {
        return QuestionnaireLanguage::where(['questionnaire_id' => $questionnaireId, 'language_id' => $langId])->first();
    }
}
