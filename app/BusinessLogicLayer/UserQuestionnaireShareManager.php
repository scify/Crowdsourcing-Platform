<?php

namespace App\BusinessLogicLayer;


use App\Repository\QuestionnaireRepository;
use App\Repository\UserQuestionnaireShareRepository;
use App\Repository\UserRepository;

class UserQuestionnaireShareManager {

    protected $questionnaireShareRepository;
    protected $questionnaireRepository;
    protected $questionnaireActionHandler;
    protected $userRepository;
    protected $webSessionManager;

    public function __construct(UserQuestionnaireShareRepository $questionnaireShareRepository,
                                QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireActionHandler $questionnaireActionHandler,
                                UserRepository $userRepository,
                                WebSessionManager $webSessionManager) {
        $this->questionnaireShareRepository = $questionnaireShareRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireActionHandler = $questionnaireActionHandler;
        $this->userRepository = $userRepository;
        $this->webSessionManager = $webSessionManager;
    }

    public function createQuestionnaireShare(int $userId, $questionnaireId) {
        return $this->questionnaireShareRepository->create(['user_id' => $userId, 'questionnaire_id' => $questionnaireId]);
    }

    public function handleQuestionnaireShare(array $parameters, int $referrerId) {
        $questionnaireId = $parameters['questionnaireId'];
        if($this->questionnaireRepository->exists(['id' => $questionnaireId]) && $this->userRepository->exists(['id' => $referrerId])) {
            $this->webSessionManager->setReferrerId($referrerId);
            $questionnaire = $this->questionnaireRepository->find($questionnaireId);
            if ($questionnaire) {
                $this->createQuestionnaireShare($referrerId, $questionnaire->id);
                $this->questionnaireActionHandler->handleQuestionnaireSharer($questionnaire, $this->userRepository->find($referrerId));
            }
        }
    }
}
