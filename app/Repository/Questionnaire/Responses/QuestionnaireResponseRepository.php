<?php


namespace App\Repository\Questionnaire\Responses;


use App\BusinessLogicLayer\UserManager;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User;
use App\Repository\Repository;
use Exception;
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

    public function transferQuestionnaireResponsesOfAnonymousUserToUser(int $user_id) {
        if (!isset($_COOKIE[UserManager::$USER_COOKIE_KEY]) || !intval($_COOKIE[UserManager::$USER_COOKIE_KEY]))
            return;
        $anonymousUserId = intval($_COOKIE[UserManager::$USER_COOKIE_KEY]);
        if ($anonymousUserId === $user_id)
            return;
        try {
            Log::info('Transferring responses from user: ' . $anonymousUserId . ' to user: ' . $user_id);
            $user = User::findOrFail($anonymousUserId);
            $questionnaireResponses = QuestionnaireResponse::where('user_id', '=', $anonymousUserId)->get();
            $questionnaireResponseQuestionnaireIds = $questionnaireResponses->pluck('questionnaire_id')->toArray();
            $questionnaireResponsesOfUser = QuestionnaireResponse::where('user_id', '=', $user_id)->get();
            foreach ($questionnaireResponsesOfUser as $response) {
                if (in_array($response->qustionnaire_id, $questionnaireResponseQuestionnaireIds))
                    $response->delete();
            }
            QuestionnaireResponse::where('user_id', '=', $anonymousUserId)->update(['user_id' => $user_id]);
            $user->delete();
            setcookie(UserManager::$USER_COOKIE_KEY, false);
            unset($_COOKIE[UserManager::$USER_COOKIE_KEY]);
        } catch (Exception $e) {
            Log::error('Transfer error:' . $e->getMessage());
            setcookie(UserManager::$USER_COOKIE_KEY, false);
            unset($_COOKIE[UserManager::$USER_COOKIE_KEY]);
        }
    }
}
