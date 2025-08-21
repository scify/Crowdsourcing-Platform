<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Models\User\UserQuestionnaireShare;
use App\Repository\Repository;

class UserQuestionnaireShareRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function getModelClassName(): string {
        return UserQuestionnaireShare::class;
    }

    public function getUserQuestionnaireSharesForUser($userId) {
        return $this->getModelInstance()->where('user_id', $userId)->get();
    }

    public function getUserQuestionnaireSharesForUserForQuestionnaire($questionnaireId, $userId) {
        return $this->getModelInstance()->where(['user_id' => $userId, 'questionnaire_id' => $questionnaireId])->count();
    }

    public function questionnaireShareExists($questionnaireId, $userId) {
        return UserQuestionnaireShare::where(['questionnaire_id' => $questionnaireId, 'user_id' => $userId])->exists();
    }
}
