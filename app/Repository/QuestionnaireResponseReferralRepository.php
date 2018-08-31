<?php

namespace App\Repository;

use App\Models\QuestionnaireResponseReferral;

class QuestionnaireResponseReferralRepository {

    function getQuestionnaireReferralsForUser($userId) {
        return QuestionnaireResponseReferral::where('referrer_id', $userId)->get();
    }

    public function create(array $array) {
        $newQuestionnaireResponseReferral = new QuestionnaireResponseReferral();
        $newQuestionnaireResponseReferral->fill($array);
        $newQuestionnaireResponseReferral->save();
        return $newQuestionnaireResponseReferral;
    }

    public function getQuestionnaireReferralsForUserForQuestionnaire(int $questionnaireId, int $userId) {
        return QuestionnaireResponseReferral::where(['referrer_id' => $userId, 'questionnaire_id' => $questionnaireId])->get();
    }
}