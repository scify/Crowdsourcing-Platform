<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\ViewModels\Questionnaire\QuestionnaireProjectGoal;

class QuestionnaireGoalManager {
    public function getQuestionnaireGoalViewModel(Questionnaire $questionnaire, int $responses_count): QuestionnaireProjectGoal {
        $responsesNeededToReachGoal = $questionnaire->goal - $responses_count;
        if ($responsesNeededToReachGoal < 0) {
            $responsesNeededToReachGoal = 0;
        }
        if ($questionnaire->goal == 0) {
            $targetAchievedPercentage = 0;
        } else {
            $targetAchievedPercentage = round($responses_count / $questionnaire->goal * 100, 1);
        }
        $goal = $questionnaire->goal;

        return new QuestionnaireProjectGoal($responsesNeededToReachGoal, $targetAchievedPercentage, $goal);
    }
}
