<?php


namespace App\BusinessLogicLayer;


use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Support\Collection;
use function Symfony\Component\Translation\t;

class CurrentQuestionnaireProvider {

    protected $questionnaireRepository;
    protected $questionnaireResponseRepository;

    public function __construct(QuestionnaireRepository         $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function getCurrentQuestionnaire(int $projectId, $userId, Collection $questionnaires, array $questionnaireIdsUserHasAnsweredTo) {
        $toReturn = null;
        // get all questionnaires for project, order by prerequisite and creation date
        if ($questionnaires->isEmpty())
            $questionnaires = $this->questionnaireRepository->getActiveQuestionnairesForProject($projectId);
        foreach ($questionnaires as $questionnaire) {
            $toReturn = $questionnaire;
            if ($this->questionnaireShouldBeContributedTo($questionnaire, $userId, $questionnaireIdsUserHasAnsweredTo))
                break;
        }
        return $toReturn;
    }

    private function questionnaireShouldBeContributedTo(Questionnaire $questionnaire, $userId, array $questionnaireIdsUserHasAnsweredTo): bool {
        if ($userId)
            $answered = in_array($questionnaire->id, $questionnaireIdsUserHasAnsweredTo);
        else
            $answered = false;
        return !$answered && !$this->questionnaireGoalIsCompleted($questionnaire);
    }

    protected function questionnaireGoalIsCompleted(Questionnaire $questionnaire): bool {
        // get all responses and see if they are equal to the questionnaire goal
        return $questionnaire->responses_count >= $questionnaire->goal;
    }

}
