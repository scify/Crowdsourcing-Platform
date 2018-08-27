<?php

namespace App\Repository;

use App\Models\QuestionnaireResponseReferral;

class QuestionnaireResponseReferralRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName() {
        return QuestionnaireResponseReferral::class;
    }

    function getQuestionnaireReferralsForUser($userId)
    {
        return $this->getModelInstance()->where('referrer_id', $userId)->get();
    }
}