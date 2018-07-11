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
    public function getAllQuestionnairesForProjectWithTranslations($projectId)
    {
        $questionnaires = DB::table('questionnaires as q')
            ->join('questionnaire_languages as ql', 'ql.questionnaire_id', '=', 'q.id')
            ->join('languages_lkp as ll', 'll.id', '=', 'ql.language_id')
            ->join('questionnaire_statuses_lkp as qsl', 'qsl.id', '=', 'q.status_id')
            ->where('q.project_id', $projectId)
            ->orderBy('q.updated_at')
            ->select('q.*', 'll.id as language_id', 'll.language_name', 'qsl.title as status_title',
                'qsl.description as status_description')
            ->get();
        return $questionnaires->groupBy('id');
    }

    public function getAllQuestionnaireStatuses()
    {
        return QuestionnaireStatus::all();
    }

    public function saveNewQuestionnaire($title, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire = DB::transaction(function() use($title, $languageId, $projectId, $questionnaireJson){
            $questionnaire = new Questionnaire();
            $questionnaire->title = $title;
            $questionnaire->default_language_id = $languageId;
            $questionnaire->project_id = $projectId;
            $questionnaire->questionnaire_json = $questionnaireJson;
            $questionnaire->save();
            // store with status 'Draft'
            $this->saveNewQuestionnaireStatusHistory($questionnaire->id, 1, 'The questionnaire has been created.');
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

    public function saveNewQuestion($questionnaireLanguageId, $questionTitle, $questionType)
    {
        $question = new QuestionnaireQuestion();
        $question->questionnaire_language_id = $questionnaireLanguageId;
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
}