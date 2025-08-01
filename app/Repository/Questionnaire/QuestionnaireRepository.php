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
    public function getModelClassName() {
        return Questionnaire::class;
    }

    public function getAllQuestionnaireStatuses() {
        return QuestionnaireStatus::all();
    }

    public function getActiveQuestionnaires() {
        return Questionnaire::where('status_id', QuestionnaireStatusLkp::PUBLISHED)
            ->with('projects')
            ->withCount('responses')
            ->orderBy('prerequisite_order')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getActiveQuestionnairesForProject(int $projectId) {
        return Questionnaire::whereHas('projects', function (Builder $query) use ($projectId) {
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

    public function countAllResponsesForQuestionnaire($questionnaireId): int {
        return DB::table('questionnaire_responses')
            ->select('questionnaire_responses.id')
            ->where('questionnaire_responses.questionnaire_id', $questionnaireId)
            ->whereNull('questionnaire_responses.deleted_at')
            ->orderBy('created_at', 'desc')->count();
    }

    public function saveNewQuestionnaire(
        $goal,
        $languageId,
        $questionnaireJson,
        $statisticsPageVisibilityLkpId,
        $maxVotesNum,
        $showGeneralStatistics,
        $type_id,
        $respondentAuthRequired,
        $show_file_type_questions_to_statistics_page_audience
    ) {
        return DB::transaction(function () use ($goal, $languageId, $questionnaireJson, $statisticsPageVisibilityLkpId, $maxVotesNum, $showGeneralStatistics, $type_id, $respondentAuthRequired, $show_file_type_questions_to_statistics_page_audience) {
            $questionnaire = new Questionnaire;
            $questionnaire = $this->storeQuestionnaire(
                $questionnaire,
                $goal,
                $languageId,
                $questionnaireJson,
                $statisticsPageVisibilityLkpId,
                $maxVotesNum,
                $showGeneralStatistics,
                $type_id,
                $respondentAuthRequired,
                $show_file_type_questions_to_statistics_page_audience
            );
            // store with status 'Draft'
            $this->saveNewQuestionnaireStatusHistory($questionnaire->id, QuestionnaireStatusLkp::DRAFT, 'The questionnaire has been created.', null);

            return $questionnaire;
        });
    }

    public function updateQuestionnaire(
        $questionnaireId,
        $goal,
        $languageId,
        $questionnaireJson,
        $statisticsPageVisibilityLkpId,
        $maxVotesNum,
        $showGeneralStatistics,
        $type_id,
        $respondentAuthRequired,
        $show_file_type_questions_to_statistics_page_audience
    ) {
        return DB::transaction(function () use ($questionnaireId, $goal, $languageId, $questionnaireJson, $statisticsPageVisibilityLkpId, $maxVotesNum, $showGeneralStatistics, $type_id, $respondentAuthRequired, $show_file_type_questions_to_statistics_page_audience) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);

            return $this->storeQuestionnaire(
                $questionnaire,
                $goal,
                $languageId,
                $questionnaireJson,
                $statisticsPageVisibilityLkpId,
                $maxVotesNum,
                $showGeneralStatistics,
                $type_id,
                $respondentAuthRequired,
                $show_file_type_questions_to_statistics_page_audience
            );
        });
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments) {
        DB::transaction(function () use ($questionnaireId, $statusId, $comments) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            $questionnaire->status_id = $statusId;
            $questionnaire->save();
            $this->saveNewQuestionnaireStatusHistory($questionnaireId, $statusId, $comments, null);
        });
    }

    public function saveNewQuestionnaireStatusHistory($questionnaireId, $statusId, $comments, $old_json): QuestionnaireStatusHistory {
        $questionnaireStatusHistory = new QuestionnaireStatusHistory;
        $questionnaire = $this->find($questionnaireId);
        $questionnaireStatusHistory->questionnaire_id = $questionnaireId;
        $questionnaireStatusHistory->status_id = $statusId;
        $questionnaireStatusHistory->updated_by_user_id = auth()->user()->id;
        $questionnaireStatusHistory->comments = $comments;
        $questionnaireStatusHistory->current_json = $questionnaire->questionnaire_json;
        $questionnaireStatusHistory->save();

        return $questionnaireStatusHistory;
    }

    private function storeQuestionnaire(
        $questionnaire,
        $goal,
        $languageId,
        $questionnaireJson,
        $statisticsPageVisibilityLkpId,
        $maxVotesNum,
        $showGeneralStatistics,
        $type_id,
        $respondentAuthRequired,
        $show_file_type_questions_to_statistics_page_audience
    ) {
        $questionnaire->goal = $goal;
        $questionnaire->default_language_id = $languageId;
        // decoding and re-encoding the json, in order to "flatten" it (no new lines)
        $questionnaire->questionnaire_json = json_encode(json_decode($questionnaireJson));
        $questionnaire->statistics_page_visibility_lkp_id = $statisticsPageVisibilityLkpId;
        $questionnaire->max_votes_num = $maxVotesNum;
        $questionnaire->show_general_statistics = $showGeneralStatistics;
        $questionnaire->type_id = $type_id;
        $questionnaire->respondent_auth_required = $respondentAuthRequired;
        $questionnaire->show_file_type_questions_to_statistics_page_audience = $show_file_type_questions_to_statistics_page_audience;
        $questionnaire->save();

        return $questionnaire;
    }

    public function getAllQuestionnairesWithRelatedInfo(array $projectIds): array {
        $projectIdsStr = implode(',', $projectIds);

        return DB::select("SELECT 
                        q.id,
                        q.prerequisite_order,
                        q.status_id,
                        q.default_language_id,
                        qft.title,
                        qft.description,
                        q.goal,
                        q.statistics_page_visibility_lkp_id,
                        q.created_at,
                        q.updated_at,
                        q.deleted_at,
                        COUNT(DISTINCT csp.id) AS num_of_projects,
                        MAX(projectData.project_info) AS project_info,
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
                        crowd_sourcing_project_translations cspt ON cspt.project_id = csp.id 
                                                                and cspt.language_id = csp.language_id
                            INNER JOIN
                        questionnaire_fields_translations qft ON qft.questionnaire_id = q.id 
                                                                and qft.language_id = q.default_language_id
                            INNER JOIN
                        languages_lkp AS dl ON dl.id = q.default_language_id
                            INNER JOIN
                        questionnaire_statuses_lkp AS qsl ON qsl.id = q.status_id
                        LEFT JOIN (
                            SELECT 
                                cspq.questionnaire_id,
                                GROUP_CONCAT(
                                    JSON_OBJECT(
                                        'name', cspt.name,
                                        'slug', csp.slug,
                                        'default_locale', lang.language_code
                                    )
                                    ORDER BY csp.id
                                    SEPARATOR ','
                                ) AS project_info
                            FROM crowd_sourcing_project_questionnaires cspq
                            JOIN crowd_sourcing_projects csp ON csp.id = cspq.project_id
                            JOIN crowd_sourcing_project_translations cspt ON cspt.project_id = csp.id 
                                                                        AND cspt.language_id = csp.language_id
                            JOIN languages_lkp lang ON cspt.language_id = lang.id
                            WHERE csp.deleted_at IS NULL
                            GROUP BY cspq.questionnaire_id
                        ) AS projectData ON projectData.questionnaire_id = q.id

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

                        
                        where cspq.project_id in ($projectIdsStr)
                        and q.deleted_at is null
                        and csp.deleted_at is null
                        GROUP BY q.id, q.prerequisite_order, q.status_id,
                        q.default_language_id,
                        qft.title,
                        qft.description,
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
