<?php

namespace App\Repository;


use App\Models\UserQuestionnaireShare;

class UserQuestionnaireShareRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName() {
        return UserQuestionnaireShare::class;
    }

    public function getUserQuestionnaireSharesForUser($userId) {
        return $this->getModelInstance()->where('user_id', $userId)->get();
    }

    public function getUserQuestionnaireSharesForUserForQuestionnaire($questionnaireId, $userId) {
        return $this->getModelInstance()->where(['user_id' => $userId, 'questionnaire_id' => $questionnaireId])->get();
    }

    public function questionnaireShareExists($questionnaireId, $userId) {
        return UserQuestionnaireShare::where(['questionnaire_id' => $questionnaireId, 'user_id' => $userId])->exists();
    }
}
