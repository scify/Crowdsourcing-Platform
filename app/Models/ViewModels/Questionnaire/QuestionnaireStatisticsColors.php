<?php


namespace App\Models\ViewModels\Questionnaire;


use App\Models\Questionnaire;

class QuestionnaireStatisticsColors {

    public $questionnaire;

    public function __construct(Questionnaire $questionnaire) {
        $this->questionnaire = $questionnaire;
    }

    public function getGoalResponsesDefaultColor() {
        return $this->questionnaire->basicStatisticsColors ?
            $this->questionnaire->basicStatisticsColors->goal_responses_color : '#000000';
    }

    public function getActualResponsesDefaultColor() {
        return $this->questionnaire->basicStatisticsColors ?
            $this->questionnaire->basicStatisticsColors->total_responses_color : '#000000';
    }

}
