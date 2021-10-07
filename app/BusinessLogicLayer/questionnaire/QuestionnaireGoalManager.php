<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\CurrentQuestionnaireProvider;
use App\Models\Questionnaire\Questionnaire;
use App\Models\ViewModels\QuestionnaireProjectGoal;
use App\Repository\Questionnaire\QuestionnaireRepository;
use Illuminate\Support\Collection;

class QuestionnaireGoalManager {

    protected $currentQuestionnaireProvider;
    protected $questionnaireRepository;

    public function __construct(CurrentQuestionnaireProvider $currentQuestionnaireProvider,
                                QuestionnaireRepository $questionnaireRepository) {
        $this->currentQuestionnaireProvider = $currentQuestionnaireProvider;
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function getQuestionnaireGoalViewModel(Questionnaire $questionnaire, int $responses_count): QuestionnaireProjectGoal {
        $responsesNeededToReachGoal = $questionnaire->goal - $responses_count;
        $targetAchievedPercentage = round($responses_count / $questionnaire->goal * 100, 1);
        $goal = $questionnaire->goal;

        return new QuestionnaireProjectGoal($responsesNeededToReachGoal, $targetAchievedPercentage, $goal);
    }

}
