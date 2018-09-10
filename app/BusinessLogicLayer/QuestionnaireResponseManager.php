<?php

namespace App\BusinessLogicLayer;


use App\Models\User;
use App\Repository\QuestionnaireRepository;

class QuestionnaireResponseManager {

    private $questionnaireRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function getQuestionnaireResponsesForUser(User $user) {
        return $this->questionnaireRepository->getAllResponsesGivenByUser($user->id);
    }

    public function questionnaireResponsesForUserExists($userId) {
        return $this->questionnaireRepository->questionnaireResponsesForUserExists($userId);
    }
}