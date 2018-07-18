<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 3:48 PM
 */

namespace App\BusinessLogicLayer;


use App\DataAccessLayer\QuestionnaireStorageManager;
use App\Models\ViewModels\CreateEditQuestionnaire;
use App\Models\ViewModels\ManageQuestionnaires;
use App\Models\ViewModels\QuestionnaireTranslation;
use Illuminate\Support\Facades\Auth;

class QuestionnaireManager
{
    private $questionnaireStorageManager;
    private $languageManager;

    public function __construct(QuestionnaireStorageManager $questionnaireStorageManager, LanguageManager $languageManager)
    {
        $this->questionnaireStorageManager = $questionnaireStorageManager;
        $this->languageManager = $languageManager;
    }

    public function getCreateEditQuestionnaireViewModel($id)
    {
        $questionnaire = null;
        $title = "Create Questionnaire";
        if (!is_null($id)) {
            $questionnaire = $this->questionnaireStorageManager->findQuestionnaire($id);
            $title = "Edit Questionnaire";
        }
        $languages = $this->languageManager->getAllLanguages();
        return new CreateEditQuestionnaire($questionnaire, $languages, $title);
    }

    public function getAllQuestionnairesForProjectViewModel($projectId)
    {
        $questionnaires = $this->questionnaireStorageManager->getAllQuestionnairesForProjectWithAvailableTranslations($projectId);
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
            $data['title'], $data['description'], $data['language'], $data['project'], $data['content']
        );
        $this->storeToAllQuestionnaireRelatedTables($questionnaire->id, $data);
    }

    public function updateQuestionnaire($id, $data)
    {
        $this->questionnaireStorageManager->updateQuestionnaire($id, $data['title'], $data['description'],
            $data['language'], $data['project'], $data['content']);
        $this->updateAllQuestionnaireRelatedTables($id, $data);
    }

    public function storeQuestionnaireResponse($data)
    {
        $response = json_decode($data['response']);
        $userId = Auth::id();
        $this->questionnaireStorageManager->saveNewQuestionnaireResponse($data['questionnaire_id'], $response, $userId, $data['response']);
    }

    public function getTranslateQuestionnaireViewModel($questionnaireId)
    {
        $questionnaire = $this->questionnaireStorageManager->findQuestionnaire($questionnaireId);
        $allLanguages = $this->languageManager->getAllLanguages()->groupBy('id');
        $defaultLanguage = $allLanguages->pull($questionnaire->default_language_id);
        $allLanguages = $this->transformAllLanguagesToArray($allLanguages);
        $questionnaireTranslations = $this->questionnaireStorageManager->getQuestionnaireTranslationsGroupedByLanguageAndQuestion($questionnaireId);
        return new QuestionnaireTranslation($questionnaireTranslations, $questionnaire, $allLanguages, $defaultLanguage[0]);
    }

    public function storeQuestionnaireTranslations($questionnaireId, $translations) {
        $this->questionnaireStorageManager->storeQuestionnaireTranslations($questionnaireId, $translations);
    }

    private function storeToAllQuestionnaireRelatedTables($questionnaireId, $data)
    {
//        $questionnaireLanguage = $this->questionnaireStorageManager->saveNewQuestionnaireLanguage($questionnaireId, $data['language']);
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        foreach ($questions as $question) {
            $questionTitle = isset($question->title) ? $question->title : $question->name;
            $questionType = $question->type;
            $storedQuestion = $this->questionnaireStorageManager->saveNewQuestion($questionnaireId, $questionTitle, $questionType, $question->name);
            if ($questionType === 'html')
                $this->questionnaireStorageManager->saveNewHtmlElement($storedQuestion->id, $question->html);
            $this->storeAllAnswers($question, $storedQuestion->id, ['rows', 'columns', 'choices', 'items']);
        }
    }

    private function updateAllQuestionnaireRelatedTables($questionnaireId, $data)
    {
//        $questionnaireLanguage = $this->questionnaireStorageManager->saveNewQuestionnaireLanguage($questionnaireId, $data['language']);
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        $this->questionnaireStorageManager->updateAllQuestionnaireRelatedTables($questionnaireId, $questions);
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
                    $value = isset($temp->value) ? $temp->value : $temp;
                    $this->questionnaireStorageManager->saveNewAnswer($questionId, $answer, $value);
                }
            }
        }
    }

    private function transformAllLanguagesToArray($allLanguages)
    {
        $result = [];
        foreach ($allLanguages as $language) {
            array_push($result, $language[0]);
        }
        return $result;
    }
}