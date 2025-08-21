<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Questionnaire;

use App\Repository\Questionnaire\Responses\QuestionnaireResponseReferralRepository;

class QuestionnaireResponseReferralManager {
    public function __construct(private readonly QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository) {}

    /**
     * @param  $questionnaireId  int the id of the questionnaire answered
     * @param  $respondentId  int the id of the user who responded
     * @param  $referrerId  int the id of the user who shared the questionnaire
     *
     * @return mixed the object created
     */
    public function createQuestionnaireResponseReferral($questionnaireId, $respondentId, $referrerId): \App\Models\Questionnaire\QuestionnaireResponseReferral {
        return $this->questionnaireResponseReferralRepository->create([
            'questionnaire_id' => $questionnaireId,
            'respondent_id' => $respondentId,
            'referrer_id' => $referrerId,
        ]);
    }
}
