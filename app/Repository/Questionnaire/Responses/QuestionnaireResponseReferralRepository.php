<?php

namespace App\Repository\Questionnaire\Responses;

use App\Models\QuestionnaireResponseReferral;
use App\Repository\Repository;

class QuestionnaireResponseReferralRepository extends Repository {
    public function getQuestionnaireReferralsForUser($userId) {
        return QuestionnaireResponseReferral::where('referrer_id', $userId)->get();
    }

    public function create(array $array) {
        $newQuestionnaireResponseReferral = new QuestionnaireResponseReferral;
        $newQuestionnaireResponseReferral->fill($array);
        $newQuestionnaireResponseReferral->save();

        return $newQuestionnaireResponseReferral;
    }

    public function questionnaireReferralByUserExists($questionnaireId, $userId) {
        return QuestionnaireResponseReferral::where(['questionnaire_id' => $questionnaireId, 'referrer_id' => $userId])->exists();
    }

    public function getQuestionnaireReferralsForUserForQuestionnaire(int $questionnaireId, int $userId) {
        return QuestionnaireResponseReferral::where(['referrer_id' => $userId, 'questionnaire_id' => $questionnaireId])->get();
    }

    public function getModelClassName() {
        return QuestionnaireResponseReferral::class;
    }
}
