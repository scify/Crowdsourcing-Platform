<?php

namespace App\BusinessLogicLayer\questionnaire;


use App\Models\User;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireResponseRepository;

class QuestionnaireResponseManager {

    private $questionnaireRepository;
    protected $questionnaireResponseRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function getQuestionnaireResponsesForUser(User $user) {
        return $this->questionnaireRepository->getAllResponsesGivenByUser($user->id);
    }

    public function questionnaireResponsesForUserExists($userId) {
        return $this->questionnaireRepository->questionnaireResponsesForUserExists($userId);
    }
}
