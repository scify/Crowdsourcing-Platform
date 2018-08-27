<?php

namespace App\BusinessLogicLayer;


use App\Repository\QuestionnaireResponseReferralRepository;

class QuestionnaireResponseReferralManager {

    private $questionnaireResponseReferralRepository;

    public function __construct(QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository) {
        $this->questionnaireResponseReferralRepository = $questionnaireResponseReferralRepository;
    }

    public function getQuestionnaireReferralsForUser($userId) {
        return $this->questionnaireResponseReferralRepository->getQuestionnaireReferralsForUser($userId);
    }
}