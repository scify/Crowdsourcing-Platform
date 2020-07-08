<?php

namespace App\Repository\QuestionnaireStatistics;

class QuestionnaireResponseStatistics {

    public $totalResponses;
    public $goalResponses;

    public function __construct(int $totalResponses, int $goalResponses) {
        $this->totalResponses = $totalResponses;
        $this->goalResponses = $goalResponses;
    }

}
