<?php


namespace App\BusinessLogicLayer;


use App\Models\Questionnaire;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireResponseRepository;

class CurrentQuestionnaireProvider {

    protected $questionnaireRepository;
    protected $questionnaireResponseRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function getCurrentQuestionnaire(int $projectId, int $userId) {
        $toReturn = null;
        // get all questionnaires for project, order by prerequisite and creation date
        $questionnaires = $this->questionnaireRepository->getActiveQuestionnairesForProject($projectId);
        foreach ($questionnaires as $questionnaire) {
            $toReturn = $questionnaire;
            $questionnaire->answered = $this->questionnaireResponseRepository->questionnaireResponseExists($questionnaire->id, $userId);
            $questionnaire->goalCompleted = $this->questionnaireGoalIsCompleted($questionnaire);
            if(!$questionnaire->answered && !$questionnaire->goalCompleted)
                break;
        }
        return $toReturn;
    }

    protected function questionnaireGoalIsCompleted(Questionnaire $questionnaire): bool {
        // get all responses and see if they are equal to the questionnaire goal
        return $questionnaire->responses->count() >= $questionnaire->goal;
    }

}
