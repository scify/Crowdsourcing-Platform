<?php


namespace App\Repository\Questionnaire;


use App\Models\QuestionnaireLanguage;
use App\Repository\Repository;

class QuestionnaireLanguageRepository extends Repository {

    function getModelClassName() {
        return QuestionnaireLanguage::class;
    }
}
