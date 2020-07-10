<?php


namespace App\Repository;


use App\Models\QuestionnaireResponse;

class QuestionnaireResponseRepository extends Repository {

    function getModelClassName() {
        return QuestionnaireResponse::class;
    }

    public function userResponseExists(int $userId): bool {
        return $this->exists(['user_id' => $userId]);
    }

    public function questionnaireResponseExists(int $questionnaireId, int $userId): bool {
        return $this->exists(['questionnaire_id' => $questionnaireId, 'user_id' => $userId]);
    }
}
