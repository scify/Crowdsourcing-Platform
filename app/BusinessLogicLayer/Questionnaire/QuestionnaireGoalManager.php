<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\ViewModels\Questionnaire\QuestionnaireProjectGoal;

class QuestionnaireGoalManager {
    public function getQuestionnaireGoalViewModel(Questionnaire $questionnaire, int $responses_count): QuestionnaireProjectGoal {
        $responsesNeededToReachGoal = $questionnaire->goal - $responses_count;
        if ($responsesNeededToReachGoal < 0) {
            $responsesNeededToReachGoal = 0;
        }

        $targetAchievedPercentage = $questionnaire->goal == 0 ? 0 : intval(round($responses_count / $questionnaire->goal * 100, 1));

        $goal = $questionnaire->goal;

        return new QuestionnaireProjectGoal($responsesNeededToReachGoal, $targetAchievedPercentage, $goal);
    }
}
