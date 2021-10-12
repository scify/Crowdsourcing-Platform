<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\Models\Questionnaire\Questionnaire;
use App\Models\ViewModels\QuestionnaireProjectGoal;

class QuestionnaireGoalManager {

    public function getQuestionnaireGoalViewModel(Questionnaire $questionnaire, int $responses_count): QuestionnaireProjectGoal {
        $responsesNeededToReachGoal = $questionnaire->goal - $responses_count;
        $targetAchievedPercentage = round($responses_count / $questionnaire->goal * 100, 1);
        $goal = $questionnaire->goal;

        return new QuestionnaireProjectGoal($responsesNeededToReachGoal, $targetAchievedPercentage, $goal);
    }

}
