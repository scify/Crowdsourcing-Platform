<?php


namespace App\Repository\Questionnaire\Responses;


use App\BusinessLogicLayer\UserManager;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User;
use App\Repository\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

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

    public function transferQuestionnaireResponsesOfAnonymousUserToUser(int $to_user_id) {
        if (!isset($_COOKIE[UserManager::$USER_COOKIE_KEY]) || !intval($_COOKIE[UserManager::$USER_COOKIE_KEY]))
            return;
        $anonymousUserId = intval($_COOKIE[UserManager::$USER_COOKIE_KEY]);
        try {
            $user = User::findOrFail($anonymousUserId);
            $this->update(['user_id' => $anonymousUserId], ['user_id' => $to_user_id]);
            $user->delete();
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
        } finally {
            unset($_COOKIE[UserManager::$USER_COOKIE_KEY]);
        }
    }
}
