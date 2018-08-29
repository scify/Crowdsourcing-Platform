<?php

namespace App\BusinessLogicLayer;


use App\Repository\UserQuestionnaireShareRepository;

class UserQuestionnaireShareManager {

    private $questionnaireShareRepository;

    public function __construct(UserQuestionnaireShareRepository $questionnaireShareRepository) {
        $this->questionnaireShareRepository = $questionnaireShareRepository;
    }

    public function getQuestionnairesSharedByUser($userId) {
        return $this->questionnaireShareRepository->getUserQuestionnaireSharesForUser($userId);
    }

    public function createQuestionnaireShare(int $userId, $questionnaireId) {
        return $this->questionnaireShareRepository->create(['user_id' => $userId, 'questionnaire_id' => $questionnaireId]);
    }
}