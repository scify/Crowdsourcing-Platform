<?php

namespace App\Repository\Questionnaire\Statistics;

class QuestionnaireResponseStatistics {

    public $totalResponses;
    public $goalResponses;

    public function __construct(int $totalResponses, int $goalResponses) {
        $this->totalResponses = $totalResponses;
        $this->goalResponses = $goalResponses;
    }

}
