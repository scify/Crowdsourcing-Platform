<?php

namespace App\Repository\Questionnaire;


use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\Questionnaire\QuestionnaireStatus;
use App\Models\Questionnaire\QuestionnaireStatusHistory;
use App\Repository\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class QuestionnaireRepository extends Repository {

    function getModelClassName() {
        return Questionnaire::class;
    }

    public function getAllQuestionnaireStatuses() {
        return QuestionnaireStatus::all();
    }

    public function getActiveQuestionnairesForProject(int $projectId) {
        return Questionnaire
            ::whereHas('projects', function (Builder $query) use ($projectId) {
                $query->where(['id' => $projectId]);
            })
            ->where('status_id', QuestionnaireStatusLkp::PUBLISHED)
            ->withCount('responses')
            ->orderBy('prerequisite_order')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getUserResponseForQuestionnaire($questionnaireId, $userId) {
        return QuestionnaireResponse::where('questionnaire_id', $questionnaireId)->where('user_id', $userId)->first();
    }

    public function getAllResponsesForQuestionnaire($questionnaireId) {
        return DB::table('questionnaire_responses')
            ->select('questionnaire_responses.created_at', 'u.nickname as user_name')
            ->join('users as u', 'u.id', '=', 'questionnaire_responses.user_id')
            ->where('questionnaire_responses.questionnaire_id', $questionnaireId)
            ->orderBy('created_at', 'desc')->get();
    }

    public function saveNewQuestionnaire($title, $description, $goal, $languageId, $questionnaireJson,
                                         $statisticsPageVisibilityLkpId) {
        return DB::transaction(function () use (
            $title, $description, $goal, $languageId, $questionnaireJson, $statisticsPageVisibilityLkpId
        ) {
            $questionnaire = new Questionnaire();
            $questionnaire = $this->storeQuestionnaire($questionnaire, $title, $description,
                $goal, $languageId, $questionnaireJson, $statisticsPageVisibilityLkpId);
            // store with status 'Draft'
            $this->saveNewQuestionnaireStatusHistory($questionnaire->id, QuestionnaireStatusLkp::DRAFT, 'The questionnaire has been created.');
            return $questionnaire;
        });
    }

    public function updateQuestionnaire($questionnaireId, $title, $description,
                                        $goal, $languageId, $questionnaireJson, $statisticsPageVisibilityLkpId) {
        return DB::transaction(function () use (
            $questionnaireId, $title, $description, $goal,
            $languageId, $questionnaireJson, $statisticsPageVisibilityLkpId
        ) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            return $this->storeQuestionnaire($questionnaire, $title, $description,
                $goal, $languageId, $questionnaireJson, $statisticsPageVisibilityLkpId);
        });
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments) {
        DB::transaction(function () use ($questionnaireId, $statusId, $comments) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            $questionnaire->status_id = $statusId;
            $questionnaire->save();
            $this->saveNewQuestionnaireStatusHistory($questionnaireId, $statusId, $comments);
        });
    }

    public function saveNewQuestionnaireStatusHistory($questionnaireId, $statusId, $comments) {
        $questionnaireStatusHistory = new QuestionnaireStatusHistory();
        $questionnaire = $this->find($questionnaireId);
        $questionnaireStatusHistory->questionnaire_id = $questionnaireId;
        $questionnaireStatusHistory->status_id = $statusId;
        $questionnaireStatusHistory->comments = $comments;
        $questionnaireStatusHistory->current_json = $questionnaire->questionnaire_json;
        $questionnaireStatusHistory->save();
        return $questionnaireStatusHistory;
    }


    private function storeQuestionnaire($questionnaire, $title, $description, $goal,
                                        $languageId, $questionnaireJson, $statisticsPageVisibilityLkpId) {
        $questionnaire->title = $title;
        $questionnaire->description = $description;
        $questionnaire->goal = $goal;
        $questionnaire->default_language_id = $languageId;
        // decoding and re-encoding the json, in order to "flatten" it (no new lines)
        $questionnaire->questionnaire_json = json_encode(json_decode($questionnaireJson));
        $questionnaire->statistics_page_visibility_lkp_id = $statisticsPageVisibilityLkpId;
        $questionnaire->save();
        return $questionnaire;
    }

    public function getAllQuestionnairesWithRelatedInfo(array $projectIds): array {
        $projectIdsStr = implode(',', $projectIds);
        return DB::
        select("SELECT 
                        q.id,
                        q.prerequisite_order,
                        q.status_id,
                        q.default_language_id,
                        q.title,
                        q.description,
                        q.goal,
                        q.statistics_page_visibility_lkp_id,
                        q.created_at,
                        q.updated_at,
                        q.deleted_at,
                        COUNT(csp.id) AS num_of_projects,
                        GROUP_CONCAT(csp.name
                            SEPARATOR ', ') AS project_names,
                        GROUP_CONCAT(csp.slug
                            SEPARATOR ', ') AS project_slugs,
       
                        qsl.title AS status_title,
                        responsesInfo.number_of_responses,
                        languagesInfo.languages,
                        qsl.description AS status_description,
                        dl.language_name AS default_language_name
                    FROM
                        questionnaires q
                            INNER JOIN
                        crowd_sourcing_project_questionnaires cspq ON cspq.questionnaire_id = q.id
                            INNER JOIN
                        crowd_sourcing_projects csp ON csp.id = cspq.project_id
                            INNER JOIN
                        languages_lkp AS dl ON dl.id = q.default_language_id
                            INNER JOIN
                        questionnaire_statuses_lkp AS qsl ON qsl.id = q.status_id
                            LEFT JOIN
                        (SELECT 
                            questionnaire_id, COUNT(*) AS number_of_responses
                        FROM
                            questionnaire_responses qr
                        INNER JOIN questionnaires q ON qr.questionnaire_id = q.id
                            AND qr.deleted_at IS NULL
                        GROUP BY questionnaire_id) AS responsesInfo ON responsesInfo.questionnaire_id = q.id
                            LEFT JOIN
                        (SELECT 
                            GROUP_CONCAT(languages_lkp.language_name
                                    SEPARATOR ', ') AS languages,
                                q.id AS questionnaire_id
                        FROM
                            questionnaire_languages ql
                        INNER JOIN languages_lkp ON ql.language_id = languages_lkp.id
                        INNER JOIN questionnaires q ON ql.questionnaire_id = q.id
                        WHERE
                            ql.deleted_at IS NULL
                            AND ql.language_id <> q.default_language_id
                        GROUP BY q.id) AS languagesInfo ON languagesInfo.questionnaire_id = q.id

                            
                        where cspq.project_id in (" . $projectIdsStr . ") 
                        and q.deleted_at is null
                        GROUP BY q.id, q.prerequisite_order, q.status_id,
                        q.default_language_id,
                        q.title,
                        q.description,
                        q.goal,
                        q.statistics_page_visibility_lkp_id,
                        q.created_at,
                        q.updated_at,
                        q.deleted_at,
                        qsl.title,
                        qsl.description,
                        dl.language_name,
                        number_of_responses,
                        languages
                        order by q.created_at desc");
    }
}
