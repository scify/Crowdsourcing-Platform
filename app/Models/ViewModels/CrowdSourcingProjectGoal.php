<?php

namespace App\Models\ViewModels;


class CrowdSourcingProjectGoal {

    public $responsesNeededToReachGoal = 0;
    public $targetAchievedPercentage = 0;
    public $goal = 0;

    public function __construct(int $responsesNeededToReachGoal, int $targetAchievedPercentage, int $goal) {
        $this->responsesNeededToReachGoal = $responsesNeededToReachGoal;
        $this->targetAchievedPercentage = $targetAchievedPercentage;
        $this->goal = $goal;
    }


}