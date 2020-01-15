<?php


namespace App\BusinessLogicLayer;


use App\Models\Questionnaire;
use App\Models\ViewModels\QuestionnaireProjectGoal;
use App\Repository\QuestionnaireRepository;

class QuestionnaireGoalManager {

    protected $currentQuestionnaireProvider;
    protected $questionnaireRepository;

    public function __construct(CurrentQuestionnaireProvider $currentQuestionnaireProvider,
                                QuestionnaireRepository $questionnaireRepository) {
        $this->currentQuestionnaireProvider = $currentQuestionnaireProvider;
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function getQuestionnaireGoalViewModel(Questionnaire $questionnaire) {

        $allResponses = $this->questionnaireRepository->getAllResponsesForQuestionnaire($questionnaire->id);
        $responsesNeededToReachGoal = $questionnaire->goal - $allResponses->count();
        $targetAchievedPercentage = round($allResponses->count() / $questionnaire->goal * 100, 1);
        $goal = $questionnaire->goal;

        return new QuestionnaireProjectGoal($responsesNeededToReachGoal, $targetAchievedPercentage, $goal);
    }

}
