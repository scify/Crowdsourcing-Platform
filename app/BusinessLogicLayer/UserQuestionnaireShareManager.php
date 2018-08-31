<?php

namespace App\BusinessLogicLayer;


use App\BusinessLogicLayer\gamification\GamificationManager;
use App\Repository\QuestionnaireRepository;
use App\Repository\UserQuestionnaireShareRepository;
use App\Repository\UserRepository;

class UserQuestionnaireShareManager {

    private $questionnaireShareRepository;
    private $questionnaireRepository;
    private $userRepository;

    public function __construct(UserQuestionnaireShareRepository $questionnaireShareRepository,
                                QuestionnaireRepository $questionnaireRepository,
                                UserRepository $userRepository) {
        $this->questionnaireShareRepository = $questionnaireShareRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->userRepository = $userRepository;
    }

    public function getQuestionnairesSharedByUser($userId) {
        return $this->questionnaireShareRepository->getUserQuestionnaireSharesForUser($userId);
    }

    public function createQuestionnaireShare(int $userId, $questionnaireId) {
        return $this->questionnaireShareRepository->create(['user_id' => $userId, 'questionnaire_id' => $questionnaireId]);
    }

    public function handleQuestionnaireShare(array $parameters, GamificationManager $gamificationManager) {
        $questionnaireId = $parameters['questionnaireId'];
        $userId = $parameters['referrerId'];
        $questionnaire = $this->questionnaireRepository->findQuestionnaire($questionnaireId);
        $user = $this->userRepository->find($userId);
        if($questionnaire && $user) {
            $this->createQuestionnaireShareForQuestionnaireIfNoneExists($questionnaire, $user, $gamificationManager);
        }
    }

    private function createQuestionnaireShareForQuestionnaireIfNoneExists($questionnaire, $user, GamificationManager $gamificationManager) {
        if(!$this->questionnaireShareRepository->questionnaireShareExists($questionnaire->id, $user->id)) {
            $this->createQuestionnaireShare($user->id, $questionnaire->id);
            $gamificationManager->notifyUserForCommunicatorBadge($questionnaire, $user);
        }
    }
}