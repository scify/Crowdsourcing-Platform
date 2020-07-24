<?php

namespace App\Repository\Questionnaire\Statistics;

class QuestionnaireResponseStatistics {

    public $totalResponses;
    public $goalResponses;
    public $totalResponsesColor;
    public $goalResponsesColor;

    public function __construct(int $totalResponses, int $goalResponses, $totalResponsesColor, $goalResponsesColor) {
        $this->totalResponses = $totalResponses;
        $this->goalResponses = $goalResponses;
        $this->totalResponsesColor = $totalResponsesColor;
        $this->goalResponsesColor = $goalResponsesColor;
    }

}
