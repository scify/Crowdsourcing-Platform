<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Responses;

use App\Models\Questionnaire\QuestionnaireResponseReferral;
use App\Repository\Repository;

class QuestionnaireResponseReferralRepository extends Repository {
    public function getQuestionnaireReferralsForUser($userId) {
        return QuestionnaireResponseReferral::where('referrer_id', $userId)->get();
    }

    public function create(array $data): QuestionnaireResponseReferral {
        $newQuestionnaireResponseReferral = new QuestionnaireResponseReferral;
        $newQuestionnaireResponseReferral->fill($data);
        $newQuestionnaireResponseReferral->save();

        return $newQuestionnaireResponseReferral;
    }

    public function questionnaireReferralByUserExists($questionnaireId, $userId) {
        return QuestionnaireResponseReferral::where(['questionnaire_id' => $questionnaireId, 'referrer_id' => $userId])->exists();
    }

    public function getQuestionnaireReferralsForUserForQuestionnaire(int $questionnaireId, int $userId) {
        return QuestionnaireResponseReferral::where(['referrer_id' => $userId, 'questionnaire_id' => $questionnaireId])->get();
    }

    public function getModelClassName(): string {
        return QuestionnaireResponseReferral::class;
    }
}
