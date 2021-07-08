<?php

namespace App\Repository\Questionnaire;


use App\Models\Questionnaire;
use App\Models\QuestionnaireHtml;
use App\Models\QuestionnairePossibleAnswer;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponse;
use App\Models\QuestionnaireResponseAnswer;
use App\Models\QuestionnaireResponseAnswerText;
use App\Models\QuestionnaireStatus;
use App\Models\QuestionnaireStatusHistory;
use App\Models\QuestionnaireTranslationPossibleAnswer;
use App\Models\QuestionnaireTranslationQuestion;
use App\Repository\Repository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class QuestionnaireRepository extends Repository {
    private $questionnaireTranslationRepository;

    public function __construct(QuestionnaireTranslationRepository $questionnaireTranslationRepository) {
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        parent::__construct(app());
    }

    function getModelClassName() {
        return Questionnaire::class;
    }

    public function getAllQuestionnaireStatuses() {
        return QuestionnaireStatus::all();
    }

    public function getActiveQuestionnairesForProject(int $projectId) {
        return Questionnaire::where('project_id', $projectId)
            ->where('status_id', 2)
            ->get()
            ->sortBy('prerequisite_order')
            ->sortByDesc('created_at');
    }

    public function getUserResponseForQuestionnaire($questionnaireId, $userId) {
        return QuestionnaireResponse::where('questionnaire_id', $questionnaireId)->where('user_id', $userId)->first();
    }

    public function getAllResponsesForQuestionnaire($questionnaireId) {
        return QuestionnaireResponse::where('questionnaire_id', $questionnaireId)->orderBy('created_at', 'desc')->get();
    }

    public function getAllResponsesGivenByUser($userId) {
        return QuestionnaireResponse::
        select('questionnaire_responses.id as questionnaire_response_id',
            'questionnaire_responses.created_at as responded_at',
            'questionnaire_responses.*', 'q.description as questionnaire_description', 'q.*', 'csp.*')
            ->join('questionnaires as q', 'q.id', '=', 'questionnaire_id')
            ->join('crowd_sourcing_projects as csp', 'csp.id', '=', 'q.project_id')
            ->where('user_id', $userId)
            ->get()
            ->sortByDesc('responded_at');
    }

    public function saveNewQuestionnaire($title, $description, $goal, $languageId,
                                         $projectId, $questionnaireJson, $prerequisiteOrder,
                                         $statisticsPageVisibilityLkpId) {
        return DB::transaction(function () use ($title, $description, $goal, $languageId,
            $projectId, $questionnaireJson, $prerequisiteOrder, $statisticsPageVisibilityLkpId) {
            $questionnaire = new Questionnaire();
            $questionnaire = $this->storeQuestionnaire($questionnaire, $title, $description,
                $goal, $languageId, $projectId, $questionnaireJson, $prerequisiteOrder, $statisticsPageVisibilityLkpId);
            // store with status 'Draft'
            $this->saveNewQuestionnaireStatusHistory($questionnaire->id, 1, 'The questionnaire has been created.');
            return $questionnaire;
        });
    }

    public function updateQuestionnaire($questionnaireId, $title, $description,
                                        $goal, $languageId, $projectId, $questionnaireJson,
                                        $prerequisiteOrder, $statisticsPageVisibilityLkpId) {
        return DB::transaction(function () use ($questionnaireId, $title, $description, $goal,
            $languageId, $projectId, $questionnaireJson,
            $prerequisiteOrder, $statisticsPageVisibilityLkpId) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            return $this->storeQuestionnaire($questionnaire, $title, $description,
                $goal, $languageId, $projectId, $questionnaireJson, $prerequisiteOrder, $statisticsPageVisibilityLkpId);
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
                                        $languageId, $projectId, $questionnaireJson,
                                        $prerequisiteOrder, $statisticsPageVisibilityLkpId) {
        $questionnaire->title = $title;
        $questionnaire->description = $description;
        $questionnaire->goal = $goal;
        $questionnaire->default_language_id = $languageId;
        $questionnaire->project_id = $projectId;
        // decoding and re-encoding the json, in order to "flatten" it (no new lines)
        $questionnaire->questionnaire_json = json_encode(json_decode($questionnaireJson));
        $questionnaire->prerequisite_order = $prerequisiteOrder;
        $questionnaire->statistics_page_visibility_lkp_id = $statisticsPageVisibilityLkpId;
        $questionnaire->save();
        return $questionnaire;
    }

    public function getAllQuestionnairesWithRelatedInfo(array $projectIds): array {
        $projectIdsStr = implode(',', $projectIds);
        return DB::
        select("select q.id, q.project_id, q.prerequisite_order, q.status_id, q.default_language_id,
                                q.title, q.description, q.goal, q.statistics_page_visibility_lkp_id,
                                q.created_at, q.updated_at, q.deleted_at,
                                csp.slug as project_slug, qsl.title as status_title, 
                                responsesInfo.number_of_responses, languagesInfo.languages,
                                qsl.description as status_description, 
                                dl.language_name as default_language_name,
                                csp.name as project_name
                                 from questionnaires as q 
                                inner join languages_lkp as dl on dl.id = q.default_language_id 
                                inner join crowd_sourcing_projects as csp on csp.id = q.project_id 
                                inner join questionnaire_statuses_lkp as qsl on qsl.id = q.status_id 
                                left join (
                                    select questionnaire_id, count(*) as number_of_responses from questionnaire_responses qr 
                                    inner join questionnaires q on qr.questionnaire_id = q.id where q.project_id in (" . $projectIdsStr . ") 
                                    and qr.deleted_at is null
                                    group by questionnaire_id
                                ) 
                                as responsesInfo 
                                on responsesInfo.questionnaire_id = q.id 
                                left join (
                                    select GROUP_CONCAT(languages_lkp.language_name SEPARATOR ', ') as languages, q.id as questionnaire_id
                                    from questionnaire_languages ql
                                    inner join languages_lkp on ql.language_id = languages_lkp.id
                                    inner join questionnaires q on ql.questionnaire_id = q.id
                                    where q.project_id in (" . $projectIdsStr . ") and ql.deleted_at is null
                                    group by  q.id
                                ) as  languagesInfo on languagesInfo.questionnaire_id = q.id
                            
                                where q.project_id in (" . $projectIdsStr . ") 
                                and q.deleted_at is null
                                order by q.updated_at desc");
    }
}
