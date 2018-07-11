<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 3:48 PM
 */

namespace App\BusinessLogicLayer;


use App\DataAccessLayer\QuestionnaireStorageManager;
use App\Models\ViewModels\ManageQuestionnaires;

class QuestionnaireManager
{
    private $questionnaireStorageManager;

    public function __construct(QuestionnaireStorageManager $questionnaireStorageManager)
    {
        $this->questionnaireStorageManager = $questionnaireStorageManager;
    }

    public function getAllQuestionnairesForProjectViewModel($projectId) {
        $questionnaires = $this->questionnaireStorageManager->getAllQuestionnairesForProjectWithTranslations($projectId);
        $availableStatuses = $this->questionnaireStorageManager->getAllQuestionnaireStatuses();
        return new ManageQuestionnaires($questionnaires, $availableStatuses);
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments)
    {
        $comments = is_null($comments) ? "" : $comments;
        $this->questionnaireStorageManager->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function createNewQuestionnaire($data)
    {
        $questionnaire = $this->questionnaireStorageManager->saveNewQuestionnaire(
            $data['title'], $data['language'], $data['project'], $data['content']
        );
        $questionnaireLanguage = $this->questionnaireStorageManager->saveNewQuestionnaireLanguage($questionnaire->id, $data['language']);
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        foreach ($questions as $question) {
            $questionTitle = isset($question->title) ? $question->title : $question->name;
            $questionType = $question->type;
            $storedQuestion = $this->questionnaireStorageManager->saveNewQuestion($questionnaireLanguage->id, $questionTitle, $questionType);
            if ($questionType === 'html')
                $this->questionnaireStorageManager->saveNewHtmlElement($storedQuestion->id, $question->html);
            $this->storeAllAnswers($question, $storedQuestion->id, ['rows', 'columns', 'choices', 'items']);
        }
    }

    private function extractDataFromQuestionnaireJson($content)
    {
        $questionnaire = json_decode($content);
        $allQuestions = [];
        foreach ($questionnaire->pages as $page) {
            if (isset($page->elements))
                $allQuestions = array_merge($allQuestions, $page->elements);
        }
        return $allQuestions;
    }

    private function storeAllAnswers($question, $questionId, array $fieldNames)
    {
        foreach ($fieldNames as $fieldName) {
            if (isset($question->$fieldName)) {
                foreach ($question->$fieldName as $temp) {
                    $answer = isset($temp->name) ? $temp->name : (isset($temp->text) ? $temp->text : $temp);
                    $this->questionnaireStorageManager->saveNewAnswer($questionId, $answer);
                }
            }
        }
    }
}