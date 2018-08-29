<?php

namespace App\BusinessLogicLayer;


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

    public function handleQuestionnaireShare(array $parameters) {
        $questionnaireId = $parameters['questionnaireId'];
        $userId = $parameters['referrerId'];
        if($questionnaireId && $userId && $this->questionnaireRepository->findQuestionnaire($questionnaireId) && $this->userRepository->find($userId)) {
            $this->createQuestionnaireShareForQuestionnaireIfNoneExists($questionnaireId, $userId);
            // todo also send email to referrer
        }
    }

    private function createQuestionnaireShareForQuestionnaireIfNoneExists($questionnaireId, $userId) {
        if(!$this->questionnaireShareRepository->questionnaireShareExists($questionnaireId, $userId)) {
            $this->createQuestionnaireShare($userId, $questionnaireId);
        }
    }
}