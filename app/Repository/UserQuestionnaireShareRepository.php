<?php

namespace App\Repository;


use App\Models\UserQuestionnaireShare;

class UserQuestionnaireShareRepository {

    function getUserQuestionnaireSharesForUser($userId)
    {
        return UserQuestionnaireShare::where('user_id', $userId)->get();
    }

    public function questionnaireShareExists($questionnaireId, $userId) {
        return UserQuestionnaireShare::where(['questionnaire_id' => $questionnaireId, 'user_id' => $userId])->exists();
    }
}