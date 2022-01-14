<?php


namespace App\Repository\Questionnaire\Responses;


use App\BusinessLogicLayer\CookieManager;
use App\BusinessLogicLayer\UserManager;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User;
use App\Repository\Repository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionnaireResponseRepository extends Repository
{

    function getModelClassName()
    {
        return QuestionnaireResponse::class;
    }

    public function userResponseExists(int $userId): bool
    {
        return $this->exists(['user_id' => $userId]);
    }

    public function questionnaireResponseExists(int $questionnaireId, int $userId): bool
    {
        return $this->exists(['questionnaire_id' => $questionnaireId, 'user_id' => $userId]);
    }

    public function deleteResponsesByUser(int $id)
    {
        return QuestionnaireResponse::whereIn('user_id', [$id])->delete();
    }

    public function restoreResponsesByUser(int $id)
    {
        return QuestionnaireResponse::onlyTrashed()->whereIn('user_id', [$id])->restore();
    }



    public function transferQuestionnaireResponsesOfAnonymousUserToUser(int $user_id)
    {
        if (!isset($_COOKIE[UserManager::$USER_COOKIE_KEY]) || !intval($_COOKIE[UserManager::$USER_COOKIE_KEY]))
            return null;
        $anonymousUserId = intval($_COOKIE[UserManager::$USER_COOKIE_KEY]);
        if ($anonymousUserId === $user_id) {
            CookieManager::deleteCookie(UserManager::$USER_COOKIE_KEY);
            return null;
        }

        $anonymousUser = User::find($anonymousUserId);
        if (!$anonymousUser){
            CookieManager::deleteCookie(UserManager::$USER_COOKIE_KEY);
            return null;
        }

        $anonymousQuestionnaireResponses = QuestionnaireResponse::where('user_id', '=', $anonymousUserId)->get();
        $anonymousQuestionnaireResponseQuestionnaireIds = $anonymousQuestionnaireResponses->pluck('questionnaire_id')->toArray();
        //find existings questionnaires of the user.
        $existingQuestionnaireResponsesOfUser = QuestionnaireResponse::where('user_id', '=', $user_id)->get();

        //if this questionnaire has been answered in the past, delete it. We keep latest, the anonymous one
        //foreach ($existingQuestionnaireResponsesOfUser as $response) {
        //                if (in_array($response->qustionnaire_id, $anonymousQuestionnaireResponseQuestionnaireIds))
        //                    $response->delete();
        //  }

        $questionnairesThatWereTransferedToUser = collect([]);
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
                $questionnairesThatWereTransferedToUser->push($anonymousResponse);
            }
        }
        $anonymousUser->delete();
        CookieManager::deleteCookie(UserManager::$USER_COOKIE_KEY);
        return $questionnairesThatWereTransferedToUser;

    }

    public function getQuestionnaireResponsesOfUser($userId)
    {
        return QuestionnaireResponse::with("questionnaire")
            ->where('user_id', $userId)
            ->get();
    }

    public function countResponsesPerProject($questionnaire_id){
        $results = DB::select('SELECT qr.project_id, CONCAT("/",l.language_code,"/",p.slug) as slug, count(*) as total FROM questionnaire_responses qr 
                                inner join crowd_sourcing_projects p on qr.project_id = p.id
                                inner join languages_lkp l on l.id = p.language_id
                                where qr.deleted_at is null and qr.questionnaire_id =?  
                                group by qr.project_id, p.slug, l.language_code
                                order by p.slug desc',[$questionnaire_id]);

        return $results;

    }

    public function getAllResponsesGivenByUser($userId)
    {
        // here we select the columns that we want to fetch, due to this mySQL 8 bug:
        // https://bugs.mysql.com/bug.php?id=103225
        return QuestionnaireResponse::
        select('questionnaire_responses.id as questionnaire_response_id',
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
            ->join('languages_lkp', function($join){
                $join->on('languages_lkp.id', '=', 'questionnaire_responses.language_id');
            })
            ->where('user_id', $userId)
            ->get()
            ->sortByDesc('responded_at');
    }
}
