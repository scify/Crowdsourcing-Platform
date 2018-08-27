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

    function getUserQuestionnaireSharesForUser($userId)
    {
        return $this->getModelInstance()->where('user_id', $userId)->get();
    }
}