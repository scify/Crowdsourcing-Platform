<?php

namespace App\BusinessLogicLayer;


use App\BusinessLogicLayer\gamification\GamificationManager;
use App\Repository\QuestionnaireRepository;
use App\Repository\UserQuestionnaireShareRepository;

class UserQuestionnaireShareManager {

    private $questionnaireShareRepository;
    private $questionnaireRepository;

    public function __construct(UserQuestionnaireShareRepository $questionnaireShareRepository,
                                QuestionnaireRepository $questionnaireRepository) {
        $this->questionnaireShareRepository = $questionnaireShareRepository;
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function getQuestionnairesSharedByUser($userId) {
        return $this->questionnaireShareRepository->getUserQuestionnaireSharesForUser($userId);
    }

    public function createQuestionnaireShare(int $userId, $questionnaireId) {
        return $this->questionnaireShareRepository->create(['user_id' => $userId, 'questionnaire_id' => $questionnaireId]);
    }

    public function handleQuestionnaireShare(array $parameters, GamificationManager $gamificationManager, $referrer) {
        $questionnaireId = $parameters['questionnaireId'];
        $questionnaire = $this->questionnaireRepository->findQuestionnaire($questionnaireId);
        if($questionnaire) {
            $this->createQuestionnaireShareForQuestionnaireIfNoneExists($questionnaire, $referrer, $gamificationManager);
        }
    }

    private function createQuestionnaireShareForQuestionnaireIfNoneExists($questionnaire, $referrer, GamificationManager $gamificationManager) {
        if(!$this->questionnaireShareRepository->questionnaireShareExists($questionnaire->id, $referrer->id)) {
            $this->createQuestionnaireShare($referrer->id, $questionnaire->id);
            $gamificationManager->notifyUserForCommunicatorBadge($questionnaire, $referrer);
        }
    }
}