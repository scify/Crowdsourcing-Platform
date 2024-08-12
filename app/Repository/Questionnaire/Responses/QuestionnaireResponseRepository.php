<?php

namespace App\Repository\Questionnaire\Responses;

use App\BusinessLogicLayer\CookieManager;
use App\BusinessLogicLayer\UserManager;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User;
use App\Repository\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QuestionnaireResponseRepository extends Repository {
    public function getModelClassName() {
        return QuestionnaireResponse::class;
    }

    public function userResponseExists(int $userId): bool {
        return $this->exists(['user_id' => $userId]);
    }

    public function questionnaireResponseExists(int $questionnaireId, int $userId): bool {
        return $this->exists(['questionnaire_id' => $questionnaireId, 'user_id' => $userId]);
    }

    public function deleteResponsesByUser(int $id) {
        return QuestionnaireResponse::whereIn('user_id', [$id])->delete();
    }

    public function restoreResponsesByUser(int $id) {
        return QuestionnaireResponse::onlyTrashed()->whereIn('user_id', [$id])->restore();
    }

    public function transferQuestionnaireResponsesOfAnonymousUserToUser(int $user_id): ?Collection {
        if (!isset($_COOKIE[UserManager::$USER_COOKIE_KEY]) || !intval($_COOKIE[UserManager::$USER_COOKIE_KEY])) {
            return null;
        }
        $anonymousUserId = intval($_COOKIE[UserManager::$USER_COOKIE_KEY]);
        if ($anonymousUserId === $user_id) {
            CookieManager::deleteCookie(UserManager::$USER_COOKIE_KEY);

            return null;
        }

        $anonymousUser = User::find($anonymousUserId);
        if (!$anonymousUser) {
            CookieManager::deleteCookie(UserManager::$USER_COOKIE_KEY);

            return null;
        }

        $anonymousQuestionnaireResponses = QuestionnaireResponse::where('user_id', '=', $anonymousUserId)->get();
        //find existing questionnaires of the user.
        $existingQuestionnaireResponsesOfUser = QuestionnaireResponse::where('user_id', '=', $user_id)->get();

        $questionnairesThatWereTransferredToUser = collect([]);
        foreach ($anonymousQuestionnaireResponses as $anonymousResponse) {
            $itHasAlreadyBeenAnswered = $existingQuestionnaireResponsesOfUser->contains(function ($existing) use ($anonymousResponse) {
                return $existing->questionnaire_id == $anonymousResponse->questionnaire_id;
            });

            if ($itHasAlreadyBeenAnswered) {
                //delete this anonymous response
                QuestionnaireResponse::where('id', '=', $anonymousResponse->id)->delete();
            } else {
                //transfer it to the new user and send email.
                QuestionnaireResponse::where('id', '=', $anonymousResponse->id)->update(['user_id' => $user_id]);
                $questionnairesThatWereTransferredToUser->push($anonymousResponse);
            }
        }
        $anonymousUser->delete();
        CookieManager::deleteCookie(UserManager::$USER_COOKIE_KEY);

        return $questionnairesThatWereTransferredToUser;
    }

    public function getQuestionnaireResponsesOfUser($userId) {
        return QuestionnaireResponse::with('questionnaire')
            ->where('user_id', $userId)
            ->get();
    }

    public function countResponsesPerProject($questionnaire_id): array {
        $driver = DB::connection()->getDriverName();
        $concatExpression = $driver === 'sqlite'
            ? '"/" || l.language_code || "/" || p.slug'
            : 'CONCAT("/", l.language_code, "/", p.slug)';

        return DB::table('questionnaire_responses as qr')
            ->select('qr.project_id', DB::raw($concatExpression . ' as slug'), DB::raw('count(*) as total'))
            ->join('crowd_sourcing_projects as p', 'qr.project_id', '=', 'p.id')
            ->join('languages_lkp as l', 'l.id', '=', 'p.language_id')
            ->whereNull('qr.deleted_at')
            ->where('qr.questionnaire_id', $questionnaire_id)
            ->groupBy('qr.project_id', 'p.slug', 'l.language_code')
            ->orderBy('p.slug', 'desc')
            ->get()
            ->toArray();
    }

    public function getAllResponsesGivenByUser($userId) {
        // here we select the columns that we want to fetch, due to this mySQL 8 bug:
        // https://bugs.mysql.com/bug.php?id=103225
        return QuestionnaireResponse::select('questionnaire_responses.id as questionnaire_response_id',
            'questionnaire_responses.created_at as responded_at',
            'questionnaire_responses.*',
            'qft.description as questionnaire_description',
            'qft.title',
            'q.questionnaire_json',
            'csp.slug as project_slug',
            'csp.logo_path as project_logo_path',
            'cspt.name as project_name',
            'languages_lkp.language_code')
            ->join('questionnaires as q', 'q.id', '=', 'questionnaire_responses.questionnaire_id')
            ->join('crowd_sourcing_projects as csp', 'csp.id', '=', 'questionnaire_responses.project_id')
            ->join('crowd_sourcing_project_translations as cspt', function ($join) {
                $join->on('cspt.project_id', '=', 'csp.id');
                $join->on('cspt.language_id', '=', 'csp.language_id');
            })
            ->join('questionnaire_fields_translations as qft', function ($join) {
                $join->on('qft.questionnaire_id', '=', 'questionnaire_responses.questionnaire_id');
                $join->on('qft.language_id', '=', 'questionnaire_responses.language_id');
            })
            ->join('languages_lkp', function ($join) {
                $join->on('languages_lkp.id', '=', 'questionnaire_responses.language_id');
            })
            ->where('user_id', $userId)
            ->get()
            ->sortByDesc('responded_at');
    }

    public function getResponseByAnonymousData(int $questionnaire_id, string $ip, string $browser_fingerprint_id) {
        return QuestionnaireResponse::where([
            'questionnaire_id' => $questionnaire_id,
        ])->where(function ($query) use ($ip, $browser_fingerprint_id) {
            $query->where('browser_ip', $ip)
                ->orWhere('browser_fingerprint_id', $browser_fingerprint_id);
        })->first();
    }
}
