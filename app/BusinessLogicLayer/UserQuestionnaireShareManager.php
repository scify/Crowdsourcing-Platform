<?php

namespace App\BusinessLogicLayer;


use App\Repository\QuestionnaireRepository;
use App\Repository\UserQuestionnaireShareRepository;

class UserQuestionnaireShareManager {

    protected $questionnaireShareRepository;
    protected $questionnaireRepository;
    protected $questionnaireActionHandler;

    public function __construct(UserQuestionnaireShareRepository $questionnaireShareRepository,
                                QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireActionHandler $questionnaireActionHandler) {
        $this->questionnaireShareRepository = $questionnaireShareRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireActionHandler = $questionnaireActionHandler;
    }

    public function createQuestionnaireShare(int $userId, $questionnaireId) {
        return $this->questionnaireShareRepository->create(['user_id' => $userId, 'questionnaire_id' => $questionnaireId]);
    }

    public function handleQuestionnaireShare(array $parameters, $referrer) {
        $questionnaireId = $parameters['questionnaireId'];
        $questionnaire = $this->questionnaireRepository->find($questionnaireId);
        if($questionnaire) {
            $this->createQuestionnaireShare($referrer->id, $questionnaire->id);
            $this->questionnaireActionHandler->handleQuestionnaireSharer($questionnaire, $referrer);
        }
    }
}
