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
use App\Utils\Translator;
use Illuminate\Support\Facades\Auth;

class QuestionnaireManager
{
    private $questionnaireStorageManager;
    private $languageManager;
    private $translator;

    public function __construct(QuestionnaireStorageManager $questionnaireStorageManager, LanguageManager $languageManager, Translator $translator)
    {
        $this->questionnaireStorageManager = $questionnaireStorageManager;
        $this->languageManager = $languageManager;
        $this->translator = $translator;
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
            $data['title'], $data['description'], $data['goal'], $data['language'], $data['project'], $data['content']
        );
        $this->storeToAllQuestionnaireRelatedTables($questionnaire->id, $data);
    }

    public function updateQuestionnaire($id, $data)
    {
        $this->questionnaireStorageManager->updateQuestionnaire($id, $data['title'], $data['description'],
            $data['goal'], $data['language'], $data['project'], $data['content']);
        $this->updateAllQuestionnaireRelatedTables($id, $data);
    }

    public function storeQuestionnaireResponse($data)
    {
        $response = json_decode($data['response']);
        $userId = Auth::id();
        $this->questionnaireStorageManager->saveNewQuestionnaireResponse($data['questionnaire_id'], $response, $userId, $data['response']);
    }

    public function getAutomaticTranslations($languageCodeToTranslateTo, $ids, $texts)
    {
        $translations = [];
        $translatedTexts = $this->translator->translateTexts($texts, $languageCodeToTranslateTo);
        foreach ($ids as $key => $id)
            $translations[$id] = $translatedTexts[$key];
        return $translations;
    }

    public function getTranslateQuestionnaireViewModel($questionnaireId)
    {
        $questionnaire = $this->questionnaireStorageManager->findQuestionnaire($questionnaireId);
        $allLanguages = $this->languageManager->getAllLanguages()->groupBy('id');
        $defaultLanguage = $allLanguages->pull($questionnaire->default_language_id);
        $allLanguages = $this->transformAllLanguagesToArray($allLanguages);
        $questionnaireTranslations = $this->questionnaireStorageManager->getQuestionnaireTranslationsGroupedByLanguageAndQuestion($questionnaireId);
        // if default value translation is set and there are some translations but not for all questions/answers/html,
        // we need to pass all the not translated strings to the other languages, so that they will be available for translation
        if ($questionnaireTranslations->has("") && $questionnaireTranslations->count() > 1) {
            $defaultLanguageTranslation = $questionnaireTranslations->pull("");
            foreach ($questionnaireTranslations->keys() as $language) {
                foreach ($defaultLanguageTranslation as $translations) {
                    $questionnaireTranslations->get($language)->push($translations);
                }
            }
        }
        return new QuestionnaireTranslation($questionnaireTranslations, $questionnaire, $allLanguages, $defaultLanguage[0]);
    }

    public function storeQuestionnaireTranslations($questionnaireId, $translations)
    {
        $this->questionnaireStorageManager->storeQuestionnaireTranslations($questionnaireId, $translations);
    }

    private function storeToAllQuestionnaireRelatedTables($questionnaireId, $data)
    {
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        foreach ($questions as $question) {
            $questionTitle = isset($question->title) ? $question->title : $question->name;
            $questionType = $question->type;
            $storedQuestion = $this->questionnaireStorageManager->saveNewQuestion($questionnaireId, $questionTitle, $questionType, $question->name, $question->valueName);
            if ($questionType === 'html')
                $this->questionnaireStorageManager->saveNewHtmlElement($storedQuestion->id, $question->html);
            $this->storeAllAnswers($question, $storedQuestion->id);
        }
    }

    private function updateAllQuestionnaireRelatedTables($questionnaireId, $data)
    {
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

    private function storeAllAnswers($question, $questionId)
    {
        if (isset($question->choices)) {
            foreach ($question->choices as $temp) {
                $answer = isset($temp->name) ? $temp->name : (isset($temp->text) ? $temp->text : $temp);
                $value = isset($temp->value) ? $temp->value : $temp;
                $this->questionnaireStorageManager->saveNewAnswer($questionId, $answer, $value, $temp->valueName);
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