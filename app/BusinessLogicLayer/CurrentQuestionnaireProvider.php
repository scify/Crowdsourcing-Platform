<?php


namespace App\BusinessLogicLayer;


use App\Models\Questionnaire;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;

class CurrentQuestionnaireProvider {

    protected $questionnaireRepository;
    protected $questionnaireResponseRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function getCurrentQuestionnaire(int $projectId, $userId) {
        $toReturn = null;
        // get all questionnaires for project, order by prerequisite and creation date
        $questionnaires = $this->questionnaireRepository->getActiveQuestionnairesForProject($projectId);
        foreach ($questionnaires as $questionnaire) {
            $toReturn = $questionnaire;
            if($userId)
                $questionnaire->answered = $this->questionnaireResponseRepository->questionnaireResponseExists($questionnaire->id, $userId);
            else
                $questionnaire->answered = false;
            $questionnaire->goalCompleted = $this->questionnaireGoalIsCompleted($questionnaire);
            if($this->questionnaireShouldBeContributedTo($questionnaire))
                break;
        }
        return $toReturn;
    }

    private function questionnaireShouldBeContributedTo(Questionnaire $questionnaire) {
        return !$questionnaire->answered && !$questionnaire->goalCompleted;
    }

    protected function questionnaireGoalIsCompleted(Questionnaire $questionnaire): bool {
        // get all responses and see if they are equal to the questionnaire goal
        return $questionnaire->responses->count() >= $questionnaire->goal;
    }

}
