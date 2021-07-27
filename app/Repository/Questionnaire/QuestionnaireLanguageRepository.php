<?php


namespace App\Repository\Questionnaire;


use App\Models\Questionnaire\QuestionnaireLanguage;
use App\Repository\Repository;
use Illuminate\Support\Collection;

class QuestionnaireLanguageRepository extends Repository {

    function getModelClassName() {
        return QuestionnaireLanguage::class;
    }

    public function getLanguagesForQuestionnaire(int $questionnaire_id): Collection {
        return QuestionnaireLanguage::where(['questionnaire_id' => $questionnaire_id])->with('language')->get();
    }

    public function deleteLanguageByForQuestionnaire(int $lang_id, int $questionnaire_id) {
        return $this->where(['language_id' => $lang_id, 'questionnaire_id' => $questionnaire_id])->forceDelete();
    }
}
