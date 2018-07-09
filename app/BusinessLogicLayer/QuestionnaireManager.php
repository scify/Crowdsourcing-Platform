<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 3:48 PM
 */

namespace App\BusinessLogicLayer;



use App\DataAccessLayer\QuestionnaireStorageManager;

class QuestionnaireManager
{
    private $questionnaireStorageManager;

    public function __construct(QuestionnaireStorageManager $questionnaireStorageManager)
    {
        $this->questionnaireStorageManager = $questionnaireStorageManager;
    }

    public function createNewQuestionnaire($data)
    {
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        $questionnaire = $this->questionnaireStorageManager->createNewQuestionnaire(
            $data['title'], $data['language'], $data['content']
        );
        $questionnaireLanguage = $this->questionnaireStorageManager->addNewQuestionnaireLanguage($questionnaire->id, $data['language']);
    }

    private function extractDataFromQuestionnaireJson($content) {
        $questionnaire = json_decode($content);
        $allQuestions = [];
        foreach ($questionnaire->pages as $page) {
            $allQuestions = array_merge($allQuestions, $page->elements);
        }
        return $allQuestions;
    }
}