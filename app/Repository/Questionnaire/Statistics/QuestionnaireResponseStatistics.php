<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Statistics;

class QuestionnaireResponseStatistics {
    /**
     * @var int
     */
    public $totalResponses;

    /**
     * @var int
     */
    public $goalResponses;

    public function __construct(int $totalResponses, int $goalResponses, public $totalResponsesColor, public $goalResponsesColor) {
        $this->totalResponses = $totalResponses;
        $this->goalResponses = $goalResponses;
    }
}
