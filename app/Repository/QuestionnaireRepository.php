<?php

namespace App\Repository;


use App\Models\Language;
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
use App\Models\QuestionnaireTranslationHtml;
use App\Models\QuestionnaireTranslationPossibleAnswer;
use App\Models\QuestionnaireTranslationQuestion;
use Illuminate\Support\Facades\DB;

class QuestionnaireRepository
{
    public function findQuestionnaire($id)
    {
        return Questionnaire::findOrFail($id);
    }

    public function getQuestionnaireAvailableLanguages($questionnaireId)
    {
        return QuestionnaireLanguage::where('questionnaire_id', $questionnaireId)->with('language')->get();
    }

    public function getAllQuestionnairesForProjectWithAvailableTranslations($projectId)
    {
        $questionnaires = DB::
        select("select q.*, qsl.title as status_title, 
                                responsesInfo.number_of_responses, languagesInfo.languages,
                                qsl.description as status_description, 
                                dl.language_name as default_language_name from questionnaires as q 
                                inner join languages_lkp as dl on dl.id = q.default_language_id 
                                inner join questionnaire_statuses_lkp as qsl on qsl.id = q.status_id 
                                left join (
                                    select questionnaire_id, count(*) as number_of_responses from questionnaire_responses qr 
                                    inner join questionnaires q on qr.questionnaire_id = q.id where q.project_id= " . $projectId . " 
                                    group by questionnaire_id
                                ) 
                                as responsesInfo 
                                on responsesInfo.questionnaire_id = q.id 
                                left join (
                                    select GROUP_CONCAT(languages_lkp.language_name SEPARATOR ', ') as languages, q.id as questionnaire_id
                                    from questionnaire_languages ql
                                    inner join languages_lkp on ql.language_id = languages_lkp.id
                                    inner join questionnaires q on ql.questionnaire_id = q.id
                                    where q.project_id= " . $projectId . " and ql.deleted_at is null
                                    group by  q.id
                                ) as  languagesInfo on languagesInfo.questionnaire_id = q.id
                            
                                where q.project_id = " . $projectId . " and q.deleted_at is null
                                order by q.updated_at desc");
        return $questionnaires;
    }

    public function getQuestionnaireTranslationsGroupedByLanguageAndQuestion($questionnaireId)
    {
        $questionnaireTranslations = DB::table('questionnaire_questions as qq')
            ->leftJoin('questionnaire_possible_answers as qpa', 'qq.id', '=', 'qpa.question_id')
            ->leftJoin('questionnaire_html as qh', 'qq.id', '=', 'qh.question_id')
            ->leftJoin('questionnaire_translation_questions as qtq', 'qq.id', '=', 'qtq.question_id')
            ->leftJoin('questionnaire_translation_html as qth', 'qh.id', '=', 'qth.html_id')
            ->leftJoin('questionnaire_languages as ql', function ($join) {
                $join->on('qtq.questionnaire_language_id', '=', 'ql.id')->orOn('qth.questionnaire_language_id', '=', 'ql.id');
            })
            ->leftJoin('questionnaire_translation_possible_answers as qta', function ($join) {
                $join->on('ql.id', '=', 'qta.questionnaire_language_id');
                $join->on('qpa.id', '=', 'qta.possible_answer_id');
            })
            ->leftJoin('languages_lkp as ll', 'ql.language_id', '=', 'll.id')
            ->where('qq.questionnaire_id', $questionnaireId)
            ->whereNull('qq.deleted_at')
            ->whereNull('qpa.deleted_at')
            ->whereNull('qh.deleted_at')
            ->whereNull('qtq.deleted_at')
            ->whereNull('ql.deleted_at')
            ->whereNull('qta.deleted_at')
            ->whereNull('qth.deleted_at')
            ->orderBy('ql.id')
            ->orderBy('qq.id')
            ->select('qq.id as question_id', 'qq.question', 'qq.name as question_name', 'qpa.id as answer_id',
                'qpa.answer', 'qpa.value as answer_value', 'qh.id as html_id',
                'qh.html', 'll.id as language_id', 'll.language_name', 'qtq.translation as translated_question',
                'qta.translation as translated_answer', 'qth.translation as translated_html')
            ->get();
        $temp = $questionnaireTranslations->groupBy('language_name');
        $result = collect([]);
        foreach ($temp as $key => $t) {
            $result->put($key, $t->groupBy('question_id'));
        }
        return $result;
    }

    public function getAllQuestionnaireStatuses()
    {
        return QuestionnaireStatus::all();
    }

    public function getAllQuestionnaires()
    {
        return Questionnaire::all();
    }

    public function getActiveQuestionnaireForProject($projectId)
    {
        // status 'Published'
        return Questionnaire::where('project_id', $projectId)->where('status_id', 2)->first();
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

    public function getAvailableLanguagesForQuestionnaire($questionnaire)
    {
        $availableLanguages = [
            (object)[
                "language_code" => $questionnaire->defaultLanguage->language_code,
                "language_name" => $questionnaire->defaultLanguage->language_name,
                "default" => true,
                "machine_generated_translation" => 0 //default language is always created by the user, while designing the questionnaire
            ]
        ];
        $questionnaireLanguages = QuestionnaireLanguage::where('questionnaire_id', $questionnaire->id)->with('language')->get();
        foreach ($questionnaireLanguages as $ql) {
            array_push($availableLanguages,
                (object)["language_code" => $ql->language->language_code,
                    "language_name" => $ql->language->language_name,
                    "default" => false,
                    "machine_generated_translation" => $ql->machine_generated_translation]
            );
        }
        return collect($availableLanguages);
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

    public function saveNewQuestionnaireLanguage($questionnaireId, $languageId)
    {
        $questionnaireLanguage = new QuestionnaireLanguage();
        $questionnaireLanguage->questionnaire_id = $questionnaireId;
        $questionnaireLanguage->language_id = $languageId;
        $questionnaireLanguage->save();
        return $questionnaireLanguage;
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

    private function getOtherAnswerTitle($question){
        if (isset($question->otherText) && is_string($question->otherText))
            return $question->otherText;
        else if (isset($question->otherText) && isset($question->otherText->default))
            return $question->otherText->default;
        else
            return "Other (please describe)";

    }
    public function saveNewOtherAnswer($questionId, $question)
    {
        $answerTitle = $this->getOtherAnswerTitle($question);
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

    public function storeQuestionnaireTranslations($questionnaireId, $translations)
    {
        $questionnaireLanguages = $this->getQuestionnaireAvailableLanguages($questionnaireId);
        DB::transaction(function () use ($questionnaireId, $translations, $questionnaireLanguages) {
            $allTranslations = [];
            // convert stdClass created by json_decode to array
            $translations = get_object_vars($translations);
            foreach ($translations as $languageId => $languageWithTranslations) {
                $questionnaireLanguage = $questionnaireLanguages->where('language_id', $languageId)->first();
                $language = Language::findOrFail($languageId);
                $languageCode = $language->language_code;
                if (is_null($questionnaireLanguage)) {
                    $questionnaireLanguage = new QuestionnaireLanguage();
                    $questionnaireLanguage->questionnaire_id = $questionnaireId;
                    $questionnaireLanguage->language_id = $languageId;
                    $questionnaireLanguage->save();
                } else {
                    $this->removeTranslationsForQuestionnaireLanguage($questionnaireLanguage->id);
                }
                foreach ($languageWithTranslations as $translations) {
                    foreach ($translations as $translation) {
                        array_push($allTranslations, (object)[
                            'questionnaire_language_id' => $questionnaireLanguage->id,
                            'id' => $translation->id,
                            'type' => $translation->type,
                            'translation' => $translation->translation,
                            'name' => $translation->name,
                            'value' => isset($translation->value) ? $translation->value : null,
                            'language_code' => $languageCode
                        ]);
                    }
                }
            }
            $allTranslations = collect($allTranslations);
            $this->storeQuestionnaireJsonWithTranslations($questionnaireId, $allTranslations);
            $allTranslations = $allTranslations->groupBy('type');
            if ($allTranslations->has('question'))
                $this->storeAllQuestionsTranslations($allTranslations->get('question'));
            if ($allTranslations->has('answer'))
                $this->storeAllAnswersTranslations($allTranslations->get('answer'));
            if ($allTranslations->has('html'))
                $this->storeAllHtmlTranslations($allTranslations->get('html'));
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
                $this->deleteHtmlTranslations($questionnaireHtml->id);
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
                $this->storeAnswer($answerFoundInDB,$this->getOtherAnswerTitle($question), "other");
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

    private function storeAllQuestionsTranslations($translations)
    {
        foreach ($translations as $translation) {
            $this->storeQuestionTranslation($translation);
        }
    }

    private function storeQuestionTranslation($translation)
    {
        $questionTranslation = new QuestionnaireTranslationQuestion();
        $questionTranslation->questionnaire_language_id = $translation->questionnaire_language_id;
        $questionTranslation->question_id = $translation->id;
        $questionTranslation->translation = $translation->translation;
        $questionTranslation->save();
        return $questionTranslation;
    }

    private function storeAllAnswersTranslations($translations)
    {
        foreach ($translations as $translation) {
            $this->storeAnswerTranslation($translation);
        }
    }

    private function storeAnswerTranslation($translation)
    {
        $answerTranslation = new QuestionnaireTranslationPossibleAnswer();
        $answerTranslation->questionnaire_language_id = $translation->questionnaire_language_id;
        $answerTranslation->possible_answer_id = $translation->id;
        $answerTranslation->translation = $translation->translation;
        $answerTranslation->save();
        return $answerTranslation;
    }

    private function storeAllHtmlTranslations($translations)
    {
        foreach ($translations as $translation) {
            $this->storeHtmlTranslation($translation);
        }
    }

    private function storeHtmlTranslation($translation)
    {
        $htmlTranslation = new QuestionnaireTranslationHtml();
        $htmlTranslation->questionnaire_language_id = $translation->questionnaire_language_id;
        $htmlTranslation->html_id = $translation->id;
        $htmlTranslation->translation = $translation->translation;
        $htmlTranslation->save();
        return $htmlTranslation;
    }

    private function removeTranslationsForQuestionnaireLanguage($questionnaireLanguageId)
    {
        QuestionnaireTranslationQuestion::where("questionnaire_language_id", $questionnaireLanguageId)->delete();
        QuestionnaireTranslationPossibleAnswer::where("questionnaire_language_id", $questionnaireLanguageId)->delete();
        QuestionnaireTranslationHtml::where("questionnaire_language_id", $questionnaireLanguageId)->delete();
    }

    private function storeQuestionnaireJsonWithTranslations($questionnaireId, $allTranslations)
    {
        $questionnaire = Questionnaire::findOrFail($questionnaireId);
        $json = json_decode($questionnaire->questionnaire_json);
        $elements = [];
        if (isset($json->pages) && isset($json->pages[0]) && isset($json->pages[0]->elements)) {
            foreach ($json->pages[0]->elements as $question) {
                $relatedTranslations = $allTranslations->where('name', $question->name);
                $questionTranslations = $relatedTranslations->where('type', 'question');
                $question->title = $this->setQuestionnaireJsonTitleWithTranslations($questionTranslations, $question);
                if (isset($question->choices)) {
                    $answerTranslations = $relatedTranslations->where('type', 'answer');
                    $question->choices = $this->setQuestionnaireJsonChoicesWithTranslations($answerTranslations, $question);
                }
                if (isset($question->html)) {
                    $htmlTranslations = $relatedTranslations->where('type', 'html');
                    $question->html = $this->setQuestionnaireJsonHtmlWithTranslations($htmlTranslations, $question);
                }
                if (isset($question->hasOther))
                {
                    $otherTranslations= $answerTranslations->where("value","other");
                    $question->otherText = $this->setQuestionnaireJsonOtherWithTranslations($otherTranslations, $question);
                }
                array_push($elements, $question);
            }
        }
        $questionnaire->questionnaire_json = '{"pages": [{"name": "page1", "elements": ' . json_encode($elements) . '}]}';
        $questionnaire->save();
    }

    private function setQuestionnaireJsonTitleWithTranslations($questionTranslations, $element)
    {
        if (isset($element->title)) {
            if (isset($element->title->default)) // if title translations already exist
                $defaultTitle = $element->title->default;
            else
                $defaultTitle = $element->title;
        } else { // if title property does not exist in element
            $defaultTitle = $element->name;
        }
        $temp = $this->setAllTranslationsForAQuestionnaireString($defaultTitle, $questionTranslations);
        return (object)$temp;
    }

    private function setQuestionnaireJsonChoicesWithTranslations($answerTranslations, $element)
    {
        $choices = [];
        foreach ($element->choices as $choice) {
            if (isset($choice->text)) {
                if (isset($choice->text->default)) // if translations already exist
                    $defaultChoice = $choice->text->default;
                else
                    $defaultChoice = $choice->text;
            } else {
                $defaultChoice = $choice;
            }
            if (isset($choice->value))
                $choiceValue = $choice->value;
            else
                $choiceValue = $choice;
            $guid = $choice->guid;
            $answers = $answerTranslations->where('value', $choiceValue);
            $temp = ['value' => $choiceValue, 'text' => $this->setAllTranslationsForAQuestionnaireString($defaultChoice, $answers),
                'guid' => $guid
            ];
            array_push($choices, $temp);
        }
        return $choices;
    }

    private function setQuestionnaireJsonHtmlWithTranslations($htmlTranslations, $element)
    {
        $temp = $this->setAllTranslationsForAQuestionnaireString(
            (isset($element->html->default) ? $element->html->default : $element->html), $htmlTranslations);
        return (object)$temp;
    }

    private function setQuestionnaireJsonOtherWithTranslations($otherTranslations, $question)
    {
        $defaultValue = $this->getOtherAnswerTitle($question);
        $temp = $this->setAllTranslationsForAQuestionnaireString($defaultValue ,$otherTranslations);
        return (object)$temp;
    }


    private function setAllTranslationsForAQuestionnaireString($defaultLanguageValue, $translations)
    {
        $temp = ['default' => $defaultLanguageValue];
        foreach ($translations as $translation) {
            $langCode = $translation->language_code;
            $temp[$langCode] = $translation->translation;
        }
        return $temp;
    }

    private function deleteAnswerTranslations($answerId)
    {
        QuestionnaireTranslationPossibleAnswer::where('possible_answer_id', $answerId)->delete();
    }

    private function deleteQuestionTranslations($questionId)
    {
        QuestionnaireTranslationQuestion::where('question_id', $questionId)->delete();
    }

    private function deleteHtmlTranslations($htmlId)
    {
        QuestionnaireTranslationHtml::where('html_id', $htmlId)->delete();
    }

    public function questionnaireResponsesForUserExists($userId) {
        return QuestionnaireResponse::where(['user_id' => $userId])->exists();
    }
}