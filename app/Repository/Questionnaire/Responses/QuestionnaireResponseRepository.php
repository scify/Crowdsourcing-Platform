<?php


namespace App\Repository\Questionnaire\Responses;


use App\Models\Questionnaire\QuestionnaireResponse;
use App\Repository\Repository;

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

    public function deleteResponsesByUser(int $id) {
        return QuestionnaireResponse::whereIn('user_id', $id)->delete();
    }

    public function restoreResponsesByUser(int $id) {
        return QuestionnaireResponse::onlyTrashed()->whereIn('user_id', $id)->restore();
    }


}
