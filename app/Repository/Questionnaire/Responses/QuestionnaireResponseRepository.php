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

    public function storeQuestionnaireResponse(int $questionnaireId,
                                               int $userId,
                                               int $languageId,
                                               string $responseJson): QuestionnaireResponse {
        $questionnaireResponse = new QuestionnaireResponse();
        $questionnaireResponse->questionnaire_id = $questionnaireId;
        $questionnaireResponse->user_id = $userId;
        $questionnaireResponse->language_id = $languageId;
        $questionnaireResponse->response_json = $responseJson;
        $questionnaireResponse->save();
        return $questionnaireResponse;
    }
}
