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
use App\Models\QuestionnaireResponse;
use App\Models\QuestionnaireResponseAnswer;
use App\Models\QuestionnaireResponseAnswerText;
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
            ->orderBy('q.updated_at', 'desc')
            ->select('q.*', 'll.id as language_id', 'll.language_name', 'qsl.title as status_title',
                'qsl.description as status_description', 'dl.language_name as default_language_name')
            ->get();
        return $questionnaires->groupBy('id');
    }

    public function getAllQuestionnaireStatuses()
    {
        return QuestionnaireStatus::all();
    }

    public function getActiveQuestionnaireForProject($projectId)
    {
        // status 'Published'
        return Questionnaire::where('project_id', $projectId)->where('status_id', 2)->first();
    }

    public function saveNewQuestionnaire($title, $description, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire = DB::transaction(function () use ($title, $description, $languageId, $projectId, $questionnaireJson) {
            $questionnaire = new Questionnaire();
            $questionnaire = $this->storeQuestionnaire($questionnaire, $title, $description, $languageId, $projectId, $questionnaireJson);
            // store with status 'Draft'
            $this->saveNewQuestionnaireStatusHistory($questionnaire->id, 1, 'The questionnaire has been created.');
            return $questionnaire;
        });
        return $questionnaire;
    }

    public function updateQuestionnaire($questionnaireId, $title, $description, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire = DB::transaction(function () use ($questionnaireId, $title, $description, $languageId, $projectId, $questionnaireJson) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            $questionnaire = $this->storeQuestionnaire($questionnaire, $title, $description, $languageId, $projectId, $questionnaireJson);
            return $questionnaire;
        });
        return $questionnaire;
    }

    public function updateAllQuestionnaireRelatedTables($questionnaireId, $questions)
    {
        DB::transaction(function () use ($questionnaireId, $questions) {
            $questionsFromDB = $this->getQuestionsForQuestionnaire($questionnaireId);
            $questionsFromDBLength = $questionsFromDB->count();
            $newQuestionsCounter = 0;
            foreach ($questions as $question) {
                $questionTitle = isset($question->title) ? $question->title : $question->name;
                $questionType = $question->type;
                if ($newQuestionsCounter >= $questionsFromDBLength)
                    $storedQuestion = $this->saveNewQuestion($questionnaireId, $questionTitle, $questionType, $question->name);
                else
                    $storedQuestion = $this->storeQuestion($questionsFromDB->get($newQuestionsCounter), $questionTitle, $questionType, $question->name);
                $this->updateHtmlElement($storedQuestion->id, $question, $questionType);
                $this->updateAllAnswers($question, $storedQuestion->id, ['rows', 'columns', 'choices', 'items']);
                $newQuestionsCounter++;
            }
            if ($newQuestionsCounter < $questionsFromDBLength) {
                for ($key = $newQuestionsCounter; $key < $questionsFromDBLength; $key++) {
                    $this->deleteQuestion($questionsFromDB->get($key)->id);
                }
            }
        });
    }

    public function saveNewQuestionnaireLanguage($questionnaireId, $languageId)
    {
        $questionnaireLanguage = new QuestionnaireLanguage();
        $questionnaireLanguage->questionnaire_id = $questionnaireId;
        $questionnaireLanguage->language_id = $languageId;
        $questionnaireLanguage->save();
        return $questionnaireLanguage;
    }

    public function saveNewQuestion($questionnaireId, $questionTitle, $questionType, $questionName)
    {
        $question = new QuestionnaireQuestion();
        $question->questionnaire_id = $questionnaireId;
        return $this->storeQuestion($question, $questionTitle, $questionType, $questionName);
    }

    public function saveNewHtmlElement($questionId, $html)
    {
        $questionnaireHtml = new QuestionnaireHtml();
        $questionnaireHtml->question_id = $questionId;
        return $this->storeHtmlElement($questionnaireHtml, $html);
    }

    public function saveNewAnswer($questionId, $answer, $value)
    {
        $questionnaireAnswer = new QuestionnairePossibleAnswer();
        $questionnaireAnswer->question_id = $questionId;
        return $this->storeAnswer($questionnaireAnswer, $answer, $value);
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

    public function saveNewQuestionnaireResponse($questionnaireId, $response, $userId, $responseJson)
    {
        return DB::transaction(function () use ($questionnaireId, $response, $userId, $responseJson) {
            $questionsFromDB = $this->getQuestionsForQuestionnaire($questionnaireId);
            $questionnaireResponse = $this->storeQuestionnaireResponse($questionnaireId, $userId, $responseJson);
            foreach ($response as $question => $answer) {
                if (strpos($question, '-Comment') === false) {
                    $foundQuestionFromDB = $questionsFromDB->where('name', $question)->first();
                    $possibleAnswers = QuestionnairePossibleAnswer::where('question_id', $foundQuestionFromDB->id)->get();
                    if (!is_array($answer))
                        $answer = [$answer];
                    foreach ($answer as $tempAnswer) {
                        $foundAnswerFromDB = $possibleAnswers->where('value', $tempAnswer)->first();
                        $commentFieldName = $question . '-Comment';
                        $this->storeQuestionnaireResponseAnswer($questionnaireResponse, $foundQuestionFromDB,
                            $foundAnswerFromDB, $tempAnswer,
                            (isset($response->$commentFieldName) ? $response->$commentFieldName : null)
                        );
                    }
                }
            }
            return $questionnaireResponse;
        });
    }

    private function storeQuestionnaire($questionnaire, $title, $description, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire->title = $title;
        $questionnaire->description = $description;
        $questionnaire->default_language_id = $languageId;
        $questionnaire->project_id = $projectId;
        $questionnaire->questionnaire_json = $questionnaireJson;
        $questionnaire->save();
        return $questionnaire;
    }

    private function getQuestionsForQuestionnaire($questionnaireId)
    {
        return QuestionnaireQuestion::where('questionnaire_id', $questionnaireId)->get();
    }

    private function storeQuestion($question, $questionTitle, $questionType, $questionName)
    {
        $question->question = $questionTitle;
        $question->name = $questionName;
        $question->type = $questionType;
        $question->save();
        return $question;
    }

    private function updateHtmlElement($questionId, $question, $questionType)
    {
        $questionnaireHtml = $this->getQuestionnaireHtmlForQuestion($questionId);
        if ($questionnaireHtml) {
            if ($questionType === 'html')
                $this->storeHtmlElement($questionnaireHtml, $question->html);
            else
                $questionnaireHtml->delete();
        } else {
            if ($questionType === 'html')
                $this->saveNewHtmlElement($questionId, $question->html);
        }
    }

    private function getQuestionnaireHtmlForQuestion($questionId)
    {
        return QuestionnaireHtml::where('question_id', $questionId)->first();
    }

    private function storeHtmlElement($questionnaireHtml, $html)
    {
        $questionnaireHtml->html = $html;
        $questionnaireHtml->save();
        return $questionnaireHtml;
    }

    private function updateAllAnswers($question, $questionId, array $fieldNames)
    {
        $answersFromDB = $this->getAllPossibleAnswersForQuestion($questionId);
        $answersFromDBLength = $answersFromDB->count();
        $newAnswersCount = 0;
        foreach ($fieldNames as $fieldName) {
            if (isset($question->$fieldName)) {
                foreach ($question->$fieldName as $temp) {
                    $answer = isset($temp->name) ? $temp->name : (isset($temp->text) ? $temp->text : $temp);
                    $value = isset($temp->value) ? $temp->value : $temp;
                    if ($newAnswersCount >= $answersFromDBLength)
                        $this->saveNewAnswer($questionId, $answer, $value);
                    else
                        $this->storeAnswer($answersFromDB->get($newAnswersCount), $answer, $value);
                    $newAnswersCount++;
                }
            }
        }
        if ($newAnswersCount < $answersFromDBLength) {
            for ($key = $newAnswersCount; $key < $answersFromDBLength; $key++) {
                $this->deleteAnswer($answersFromDB->get($key)->id);
            }
        }
    }

    private function getAllPossibleAnswersForQuestion($questionId)
    {
        return QuestionnairePossibleAnswer::where('question_id', $questionId)->get();
    }

    private function storeAnswer($questionnaireAnswer, $answer, $value)
    {
        $questionnaireAnswer->answer = $answer;
        $questionnaireAnswer->value = $value;
        $questionnaireAnswer->save();
        return $questionnaireAnswer;
    }

    private function deleteAnswer($answerId)
    {
        $answer = QuestionnairePossibleAnswer::findOrFail($answerId);
        $answer->delete();
    }

    private function deleteQuestion($questionId)
    {
        $question = QuestionnaireQuestion::findOrFail($questionId);
        $question->delete();
    }

    private function storeQuestionnaireResponse($questionnaireId, $userId, $responseJson)
    {
        $questionnaireResponse = new QuestionnaireResponse();
        $questionnaireResponse->questionnaire_id = $questionnaireId;
        $questionnaireResponse->user_id = $userId;
        $questionnaireResponse->response_json = $responseJson;
        $questionnaireResponse->save();
        return $questionnaireResponse;
    }

    private function storeQuestionnaireResponseAnswer($questionnaireResponse, $foundQuestionFromDB, $foundAnswerFromDB, $answer, $comment)
    {
        $responseAnswer = new QuestionnaireResponseAnswer();
        $responseAnswer->questionnaire_response_id = $questionnaireResponse->id;
        $responseAnswer->question_id = $foundQuestionFromDB->id;
        if (is_null($foundAnswerFromDB)) {
            $responseAnswer->save();
            $answerText = new QuestionnaireResponseAnswerText();
            $answerText->questionnaire_response_answer_id = $responseAnswer->id;
            // if value is "Other", then there will be a key containing the answer in the $response array,
            // for example: if user gives to question1 the answer "other", a key $question1-Comment
            // should exist inside the $response array that will contain the answer written by user
            if (!is_null($comment)) {
                $answerText->answer = $comment;
            } else {
                $answerText->answer = $answer;
            }
            $answerText->save();
        } else {
            $responseAnswer->answer_id = $foundAnswerFromDB->id;
            $responseAnswer->save();
        }
        return $responseAnswer;
    }
}