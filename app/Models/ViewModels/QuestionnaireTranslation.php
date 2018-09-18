<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/17/18
 * Time: 1:18 PM
 */

namespace App\Models\ViewModels;


class QuestionnaireTranslation
{
    public $questionnaireTranslations;
    public $questionnaire;
    public $allLanguages;
    public $defaultLanguage;
    public $questionnaireLanguages;

    public function __construct($questionnaireTranslations, $questionnaireLanguages, $questionnaire, $allLanguages, $defaultLanguage)
    {
        $this->questionnaireTranslations = $questionnaireTranslations;
        $this->questionnaire = $questionnaire;
        $this->allLanguages = $allLanguages;
        $this->defaultLanguage = $defaultLanguage;
        $this->questionnaireLanguages = $questionnaireLanguages;
    }
}