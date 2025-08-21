<?php

declare(strict_types=1);

namespace App\ViewModels\Questionnaire;

class QuestionnaireProjectGoal {
    /**
     * @var int
     */
    public $responsesNeededToReachGoal = 0;

    /**
     * @var int
     */
    public $targetAchievedPercentage = 0;

    /**
     * @var int
     */
    public $goal = 0;

    public function __construct(int $responsesNeededToReachGoal, int $targetAchievedPercentage, int $goal) {
        $this->responsesNeededToReachGoal = $responsesNeededToReachGoal;
        $this->targetAchievedPercentage = $targetAchievedPercentage;
        $this->goal = $goal;
    }
}
