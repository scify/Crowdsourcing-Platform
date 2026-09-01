<?php

declare(strict_types=1);

namespace App\ViewModels\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireLanguage;

class QuestionnaireStatisticsColors {
    /**
     * @var Questionnaire
     */
    public $questionnaire;

    public function __construct(Questionnaire $questionnaire) {
        $this->questionnaire = $questionnaire;
    }

    public function getGoalResponsesDefaultColor() {
        return $this->questionnaire->basicStatisticsColors ?
            $this->questionnaire->basicStatisticsColors->goal_responses_color : '#004F9F';
    }

    public function getActualResponsesDefaultColor() {
        return $this->questionnaire->basicStatisticsColors ?
            $this->questionnaire->basicStatisticsColors->total_responses_color : '#28a745';
    }

    public function getColorForQuestionnaireLanguage(QuestionnaireLanguage $questionnaireLanguage) {
        if ($questionnaireLanguage->color) {
            return $questionnaireLanguage->color;
        }

        return $questionnaireLanguage->language->default_color;
    }
}
