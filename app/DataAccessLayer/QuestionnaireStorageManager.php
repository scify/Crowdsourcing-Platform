<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:31 PM
 */

namespace App\DataAccessLayer;


use App\Models\Questionnaire;
use App\Models\QuestionnaireLanguage;
use App\Models\QuestionnairePossibleAnswer;
use App\Models\QuestionnaireQuestion;

class QuestionnaireStorageManager
{
    public function saveNewQuestionnaire($title, $languageId, $questionnaireJson)
    {
        $questionnaire = new Questionnaire();
        $questionnaire->title = $title;
        $questionnaire->default_language_id = $languageId;
        $questionnaire->questionnaire_json = $questionnaireJson;
        $questionnaire->save();
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

    public function saveNewAnswer($questionId, $answer)
    {
        $questionnaireAnswer = new QuestionnairePossibleAnswer();
        $questionnaireAnswer->question_id = $questionId;
        $questionnaireAnswer->answer = $answer;
        $questionnaireAnswer->save();
        return $questionnaireAnswer;
    }
}