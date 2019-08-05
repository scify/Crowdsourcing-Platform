<?php
/**
 * Created by IntelliJ IDEA.
 * User: pisaris
 * Date: 18/3/2019
 * Time: 3:46 μμ
 */

namespace App\BusinessLogicLayer;


use App\Repository\QuestionnaireRepository;

class QuestionnaireAnswerManager {

    private $questionnaireRepository;

    /**
     * QuestionnaireAnswerManager constructor.
     * @param $questionnaireRepository
     */
    public function __construct(QuestionnaireRepository $questionnaireRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
    }


    public function userHasAlreadyAnsweredTheActiveQuestionnaire($userId, $projectId = CrowdSourcingProjectManager::DEFAULT_PROJECT_ID) {
        $activeQuestionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject($projectId, $userId);
        if(!$activeQuestionnaire)
            return false;
        $userResponse = $this->questionnaireRepository->getUserResponseForQuestionnaire($activeQuestionnaire->id, $userId);
        return $userResponse !== null;
    }

}