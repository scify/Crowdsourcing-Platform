<?php


namespace App\Models\ViewModels\Questionnaire;


use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireLanguage;
use App\Models\QuestionnairePossibleAnswer;

class QuestionnaireStatisticsColors {

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
        if($questionnaireLanguage->color)
            return $questionnaireLanguage->color;
        return $questionnaireLanguage->language->default_color;
    }

    public function getColorForPossibleAnswer(QuestionnairePossibleAnswer $possibleAnswer) {
        if($possibleAnswer->color)
            return $possibleAnswer->color;
        return $this->getRandomColor();
    }

    private function getRandomColor() {
        $colors = [
            "#ef5350", "#ab47bc", "#5c6bc0",
            "#66bb6a", "#ffa726", "#8d6e63",
            "#bdbdbd", "#ffee58", "#42a5f5",
            "#26a69a", "#ec407a", "#78909c",
            "#827717", "#8D6E63", "#607D8B",
            "#ff1744", "#00C853", "#FFFF00"
        ];
        return $colors[array_rand($colors, 1)];
    }

}
