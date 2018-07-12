<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:31 PM
 */

namespace App\DataAccessLayer;


use App\Models\Questionnaire;
use App\Models\QuestionnaireHtml;
use App\Models\QuestionnaireLanguage;
use App\Models\QuestionnairePossibleAnswer;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireStatus;
use App\Models\QuestionnaireStatusHistory;
use Illuminate\Support\Facades\DB;

class QuestionnaireStorageManager
{
    public function findQuestionnaire($id)
    {
        return Questionnaire::findOrFail($id);
    }

    public function getAllQuestionnairesForProjectWithTranslations($projectId)
    {
        $questionnaires = DB::table('questionnaires as q')
            ->leftJoin('questionnaire_languages as ql', 'ql.questionnaire_id', '=', 'q.id')
            ->leftJoin('languages_lkp as ll', 'll.id', '=', 'ql.language_id')
            ->join('languages_lkp as dl', 'dl.id', '=', 'q.default_language_id')
            ->join('questionnaire_statuses_lkp as qsl', 'qsl.id', '=', 'q.status_id')
            ->where('q.project_id', $projectId)
            ->whereNull('q.deleted_at')
            ->orderBy('q.updated_at')
            ->select('q.*', 'll.id as language_id', 'll.language_name', 'qsl.title as status_title',
                'qsl.description as status_description', 'dl.language_name as default_language_name')
            ->get();
        return $questionnaires->groupBy('id');
    }

    public function getAllQuestionnaireStatuses()
    {
        return QuestionnaireStatus::all();
    }

    public function saveNewQuestionnaire($title, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire = DB::transaction(function () use ($title, $languageId, $projectId, $questionnaireJson) {
            $questionnaire = new Questionnaire();
            $questionnaire = $this->storeQuestionnaire($questionnaire, $title, $languageId, $projectId, $questionnaireJson);
            // store with status 'Draft'
            $this->saveNewQuestionnaireStatusHistory($questionnaire->id, 1, 'The questionnaire has been created.');
            return $questionnaire;
        });
        return $questionnaire;
    }

    public function updateQuestionnaire($questionnaireId, $title, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire = DB::transaction(function () use ($questionnaireId, $title, $languageId, $projectId, $questionnaireJson) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            $this->deleteAllQuestionnaireRelatedData($questionnaireId);
            $questionnaire = $this->storeQuestionnaire($questionnaire, $title, $languageId, $projectId, $questionnaireJson);
            return $questionnaire;
        });
        return $questionnaire;
    }

    public function saveNewQuestionnaireLanguage($questionnaireId, $languageId)
    {
        $questionnaireLanguage = new QuestionnaireLanguage();
        $questionnaireLanguage->questionnaire_id = $questionnaireId;
        $questionnaireLanguage->language_id = $languageId;
        $questionnaireLanguage->save();
        return $questionnaireLanguage;
    }

    public function saveNewQuestion($questionnaireId, $questionTitle, $questionType)
    {
        $question = new QuestionnaireQuestion();
        $question->questionnaire_id = $questionnaireId;
        $question->question = $questionTitle;
        $question->type = $questionType;
        $question->save();
        return $question;
    }

    public function saveNewHtmlElement($questionId, $html)
    {
        $questionnaireHtml = new QuestionnaireHtml();
        $questionnaireHtml->question_id = $questionId;
        $questionnaireHtml->html = $html;
        $questionnaireHtml->save();
        return $questionnaireHtml;
    }

    public function saveNewAnswer($questionId, $answer)
    {
        $questionnaireAnswer = new QuestionnairePossibleAnswer();
        $questionnaireAnswer->question_id = $questionId;
        $questionnaireAnswer->answer = $answer;
        $questionnaireAnswer->save();
        return $questionnaireAnswer;
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments)
    {
        DB::transaction(function () use ($questionnaireId, $statusId, $comments) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            $questionnaire->status_id = $statusId;
            $questionnaire->save();
            $this->saveNewQuestionnaireStatusHistory($questionnaireId, $statusId, $comments);
        });
    }

    public function saveNewQuestionnaireStatusHistory($questionnaireId, $statusId, $comments)
    {
        $questionnaireStatusHistory = new QuestionnaireStatusHistory();
        $questionnaireStatusHistory->questionnaire_id = $questionnaireId;
        $questionnaireStatusHistory->status_id = $statusId;
        $questionnaireStatusHistory->comments = $comments;
        $questionnaireStatusHistory->save();
        return $questionnaireStatusHistory;
    }

    private function storeQuestionnaire($questionnaire, $title, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire->title = $title;
        $questionnaire->default_language_id = $languageId;
        $questionnaire->project_id = $projectId;
        $questionnaire->questionnaire_json = $questionnaireJson;
        $questionnaire->save();
        return $questionnaire;
    }

    private function deleteAllQuestionnaireRelatedData($questionnaireId)
    {
        $questionnaireLanguage = QuestionnaireLanguage::where('questionnaire_id', $questionnaireId)->first();
        $questionnaireQuestions = QuestionnaireQuestion::where('questionnaire_language_id', $questionnaireLanguage->id)->get();
        foreach ($questionnaireQuestions as $question) {
            if ($question->type === 'html') {
                $questionnaireHtml = QuestionnaireHtml::where('question_id', $question->id)->first();
                if ($questionnaireHtml)
                    $questionnaireHtml->delete();
            } else {
                $questionnaireAnswers = QuestionnairePossibleAnswer::where('question_id', $question->id)->get();
                foreach ($questionnaireAnswers as $answer) {
                    $answer->delete();
                }
            }
            $question->delete();
        }
        $questionnaireLanguage->delete();
    }
}