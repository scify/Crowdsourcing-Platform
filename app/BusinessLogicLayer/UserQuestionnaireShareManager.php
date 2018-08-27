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
}