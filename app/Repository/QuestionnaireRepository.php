<?php

namespace App\Repository;


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
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionnaireRepository
{
    private $questionnaireTranslationRepository;

    public function __construct(QuestionnaireTranslationRepository $questionnaireTranslationRepository) {
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
    }


    public function findQuestionnaire($id)
    {
        return Questionnaire::findOrFail($id);
    }

    public function getAllQuestionnaireStatuses()
    {
        return QuestionnaireStatus::all();
    }

    public function getAllQuestionnaires()
    {
        return Questionnaire::all();
    }

    public function getActiveQuestionnaireForProject($projectId, $userId)
    {
        // get all active questionnaires for this project, ordered by prerequisite_order and created_at
        // for each questionnaire, if it is a prerequisite and has not been answered by the logged in user,
        // return this questionnaire.
        $questionnaires = $this->getActiveQuestionnairesForProject($projectId);
        foreach ($questionnaires as $questionnaire) {
            $response = $this->getUserResponseForQuestionnaire($questionnaire->id, $userId);
            if(!$response) {
                return $questionnaire;
            }
        }
        return null;
    }

    public function getActiveQuestionnairesForProject(int $projectId) {
        return Questionnaire::where('project_id', $projectId)
            ->where('status_id', 2)
            ->orderBy('prerequisite_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getUserResponseForQuestionnaire($questionnaireId, $userId)
    {
        return QuestionnaireResponse::where('questionnaire_id', $questionnaireId)->where('user_id', $userId)->first();
    }

    public function getAllResponsesForQuestionnaire($questionnaireId)
    {
        return QuestionnaireResponse::where('questionnaire_id', $questionnaireId)->orderBy('created_at', 'desc')->with('user')->get();
    }

    public function getAllResponsesGivenByUser($userId)
    {
        return QuestionnaireResponse::
            select('questionnaire_responses.id as questionnaire_response_id','questionnaire_responses.*', 'q.description as questionnaire_description', 'q.*', 'csp.*')
            ->join('questionnaires as q', 'q.id', '=', 'questionnaire_id')
            ->join('crowd_sourcing_projects as csp', 'csp.id', '=', 'q.project_id')
            ->where('user_id', $userId)
            ->get();
    }

    public function saveNewQuestionnaire($title, $description, $goal, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire = DB::transaction(function () use ($title, $description, $goal, $languageId, $projectId, $questionnaireJson) {
            $questionnaire = new Questionnaire();
            $questionnaire = $this->storeQuestionnaire($questionnaire, $title, $description, $goal, $languageId, $projectId, $questionnaireJson);
            // store with status 'Draft'
            $this->saveNewQuestionnaireStatusHistory($questionnaire->id, 1, 'The questionnaire has been created.');
            return $questionnaire;
        });
        return $questionnaire;
    }

    public function updateQuestionnaire($questionnaireId, $title, $description, $goal, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire = DB::transaction(function () use ($questionnaireId, $title, $description, $goal, $languageId, $projectId, $questionnaireJson) {
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            $questionnaire = $this->storeQuestionnaire($questionnaire, $title, $description, $goal, $languageId, $projectId, $questionnaireJson);
            return $questionnaire;
        });
        return $questionnaire;
    }

    public function updateAllQuestionnaireRelatedTables($questionnaireId, $questions)
    {
        $questionsFromDB = $this->getQuestionsForQuestionnaire($questionnaireId);
        DB::transaction(function () use ($questionnaireId, $questions, $questionsFromDB) {
            $guidsUsed = [];
            $index = 1;
            foreach ($questions as $question) {
                $questionTitle = isset($question->title) ?
                    (isset($question->title->default) ? $question->title->default : $question->title) : $question->name;
                $questionType = $question->type;
                $guid = $question->guid;
                array_push($guidsUsed, $guid);
                $questionFoundInDB = $questionsFromDB->where('guid', $guid)->first();
                try{
                    if ($questionFoundInDB)
                        $storedQuestion = $this->storeQuestion($questionFoundInDB, $questionTitle, $questionType, $question->name, $index);
                    else
                        $storedQuestion = $this->saveNewQuestion($questionnaireId, $questionTitle, $questionType, $question->name, $guid, $index);
                }
                catch (Exception $e){
                    throw e;
                }

                $this->updateHtmlElement($storedQuestion->id, $question, $questionType);
                $this->updateAllAnswers($question, $storedQuestion->id);
                $index++;
            }
            $questionsFromDBToBeDeleted = $questionsFromDB->whereNotIn('guid', $guidsUsed);
            if ($questionsFromDBToBeDeleted->count() > 0) {
                $answersToBeDeletedBecauseQuestionsAreBeingDeleted = QuestionnairePossibleAnswer::whereIn(
                    'question_id', $questionsFromDBToBeDeleted->pluck('id')->toArray()
                )->get();
                $this->deleteAnswers($answersToBeDeletedBecauseQuestionsAreBeingDeleted);
                $this->deleteQuestions($questionsFromDBToBeDeleted);
            }
        });
    }

    public function saveNewQuestion($questionnaireId, $questionTitle, $questionType, $questionName, $questionguid, $orderId)
    {
        $question = new QuestionnaireQuestion();
        $question->questionnaire_id = $questionnaireId;
        $question->guid = $questionguid;
        $question->order_id = $orderId;
        return $this->storeQuestion($question, $questionTitle, $questionType, $questionName, $orderId);
    }

    public function saveNewHtmlElement($questionId, $html)
    {
        $questionnaireHtml = new QuestionnaireHtml();
        $questionnaireHtml->question_id = $questionId;
        return $this->storeHtmlElement($questionnaireHtml, $html);
    }



    public function saveNewOtherAnswer($questionId, $question)
    {
        $answerTitle = $this->questionnaireTranslationRepository->getOtherAnswerTitle($question);
        $this->saveNewAnswer($questionId, $answerTitle, "other", 'other');

    }

    public function saveNewAnswer($questionId, $answer, $value, $guid)
    {
        $questionnaireAnswer = new QuestionnairePossibleAnswer();
        $questionnaireAnswer->question_id = $questionId;
        $questionnaireAnswer->guid = $guid;
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
        $questionsFromDB = $this->getQuestionsForQuestionnaire($questionnaireId);
        return DB::transaction(function () use ($questionnaireId, $response, $userId, $responseJson, $questionsFromDB) {
            $questionnaireResponse = $this->storeQuestionnaireResponse($questionnaireId, $userId, $responseJson);
            foreach ($response as $question => $answerResponseArray) {
                if (strpos($question, '-Comment') === false) {
                    $foundQuestionFromDB = $questionsFromDB->where('name', $question)->first();
                    $possibleAnswers = QuestionnairePossibleAnswer::where('question_id', $foundQuestionFromDB->id)->get();
                    if (!is_array($answerResponseArray))
                        $answerResponseArray = [$answerResponseArray];
                    foreach ($answerResponseArray as $answerResponse) {
                        $foundAnswerFromDB = $possibleAnswers->where('value', $answerResponse)->first();
                        $answerTextToStore = null;
                        if ($foundAnswerFromDB ==null){
                            //this only occurs when the question is of type "text"
                            // At this scenario the response contains text enterned by the user
                            $answerTextToStore = $answerResponse;
                        }
                        else if ($answerResponse=="other"){
                            // if value is "Other", then there will be a key containing the answer in the $response array,
                            // for example: if user gives to question1 the answer "other", a key $question1-Comment
                            // should exist inside the $response array that will contain the answer written by user
                            $commentFieldName = $question . '-Comment';
                            $answerTextToStore =(isset($response->$commentFieldName)) ? $response->$commentFieldName : null;
                        }


                        $this->storeQuestionnaireResponseAnswer($questionnaireResponse,
                            $foundQuestionFromDB,
                            $foundAnswerFromDB,
                            $answerTextToStore
                        );

                    }
                }
            }
            return $questionnaireResponse;
        });
    }



    private function storeQuestionnaire($questionnaire, $title, $description, $goal, $languageId, $projectId, $questionnaireJson)
    {
        $questionnaire->title = $title;
        $questionnaire->description = $description;
        $questionnaire->goal = $goal;
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

    private function storeQuestion(QuestionnaireQuestion $question, $questionTitle, $questionType, $questionName, $index)
    {
        $question->question = $questionTitle;
        $question->name = $questionName;
        $question->type = $questionType;
        $question->order_id = $index;
        $question->save();
        return $question;
    }

    private function updateHtmlElement($questionId, $question, $questionType)
    {
        $questionnaireHtml = $this->getQuestionnaireHtmlForQuestion($questionId);
        if ($questionnaireHtml) {
            if ($questionType === 'html')
                $this->storeHtmlElement($questionnaireHtml, (isset($question->html->default) ? $question->html->default : $question->html));
            else {
                $questionnaireHtml->delete();
                $this->questionnaireTranslationRepository->deleteHtmlTranslations($questionnaireHtml->id);
            }
        } else {
            if ($questionType === 'html')
                $this->saveNewHtmlElement($questionId, (isset($question->html->default) ? $question->html->default : $question->html));
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

    private function updateAllAnswers($question, $questionId)
    {
        $answersFromDB = $this->getAllPossibleAnswersForQuestion($questionId);
        $guidsUsed = [];
        if (isset($question->choices)) {
            foreach ($question->choices as $temp) {
                $answer = isset($temp->text) ? (isset($temp->text->default) ? $temp->text->default : $temp->text) :
                    (isset($temp->name) ? $temp->name : $temp);
                $value = isset($temp->value) ? $temp->value : $temp;
                $guid = $temp->guid;
                array_push($guidsUsed, $guid);
                $answerFoundInDB = $answersFromDB->where('guid', $guid)->first();
                if ($answerFoundInDB)
                    $this->storeAnswer($answerFoundInDB, $answer, $value);
                else
                    $this->saveNewAnswer($questionId, $answer, $value, $guid);
            }
        }
        if (isset($question->hasOther)) {
            //add this so they won't be deleted. All answers that are type of other have the same guid with value ("other").
            // This is a hack..we should revice the mechanism with the guid, maybe they are not needed at all, since we have a "name" column that seems to be unique for each question
            array_push($guidsUsed, "other");
            $answerFoundInDB = $answersFromDB->where('guid',"=", "other")->first();
            if ($answerFoundInDB)
                $this->storeAnswer($answerFoundInDB,$this->questionnaireTranslationRepository->getOtherAnswerTitle($question), "other");
            else
                $this->saveNewOtherAnswer($questionId,$question);
        }

        $answersFromDBToBeDeleted = $answersFromDB->whereNotIn('guid', $guidsUsed);
        if ($answersFromDBToBeDeleted->count() > 0)
            $this->deleteAnswers($answersFromDBToBeDeleted);
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

    private function deleteAnswers($answers)
    {
        foreach ($answers as $answer) {
            QuestionnairePossibleAnswer::where('id', $answer->id)->delete();
            $this->deleteAnswerTranslations($answer->id);
        }
    }

    private function deleteQuestions($questions)
    {
        foreach ($questions as $question) {
            QuestionnaireQuestion::where('id', $question->id)->delete();
            $this->deleteQuestionTranslations($question->id);
        }
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

    private function storeQuestionnaireResponseAnswer($questionnaireResponse, $foundQuestionFromDB, $foundAnswerFromDB, $comment)
    {
        $responseAnswer = new QuestionnaireResponseAnswer();
        $responseAnswer->questionnaire_response_id = $questionnaireResponse->id;
        $responseAnswer->question_id = $foundQuestionFromDB->id;
        if (!is_null($foundAnswerFromDB))
            $responseAnswer->answer_id = $foundAnswerFromDB->id;

        $responseAnswer->save();

        if (!is_null($comment)) {
            $answerText = new QuestionnaireResponseAnswerText();
            $answerText->questionnaire_response_answer_id = $responseAnswer->id;
            $answerText->answer = $comment;
            $answerText->save();
        }
        /*else {
            $answerText->answer = $answer;
        }*/


        return $responseAnswer;
    }

    private function deleteAnswerTranslations($answerId)
    {
        QuestionnaireTranslationPossibleAnswer::where('possible_answer_id', $answerId)->delete();
    }

    private function deleteQuestionTranslations($questionId)
    {
        QuestionnaireTranslationQuestion::where('question_id', $questionId)->delete();
    }

    public function questionnaireResponsesForUserExists($userId) {
        return QuestionnaireResponse::where(['user_id' => $userId])->exists();
    }

}