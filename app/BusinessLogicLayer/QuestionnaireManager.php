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
use App\Notifications\QuestionnaireResponded;
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
        $user = Auth::user();
        $questionnaire = $this->questionnaireStorageManager->findQuestionnaire($data['questionnaire_id']);
        $this->questionnaireStorageManager->saveNewQuestionnaireResponse($data['questionnaire_id'], $response, $user->id, $data['response']);
        $badge = $this->getNewContributorBadgeForLoggedInUser($questionnaire->project_id);
        $user->notify(new QuestionnaireResponded($questionnaire, $badge->badgeName));
        return $badge->html;
    }

    public function getAutomaticTranslations($languageCodeToTranslateTo, $ids, $texts)
    {
        $translations = [];
        $translatedTexts = $this->translator->translateTexts($texts, $languageCodeToTranslateTo);
        foreach ($ids as $key => $id)
            $translations[$id] = str_replace('&quot;', '"', $translatedTexts[$key]);
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
        $this->questionnaireStorageManager->storeQuestionnaireTranslations($questionnaireId, json_decode($translations));
    }

    private function storeToAllQuestionnaireRelatedTables($questionnaireId, $data)
    {
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        foreach ($questions as $question) {
            $questionTitle = isset($question->title) ? $question->title : $question->name;
            $questionType = $question->type;
            $storedQuestion = $this->questionnaireStorageManager->saveNewQuestion($questionnaireId, $questionTitle, $questionType, $question->name, $question->guid);
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
                $this->questionnaireStorageManager->saveNewAnswer($questionId, $answer, $value, $temp->guid);
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

    private function getNewContributorBadgeForLoggedInUser($projectId)
    {
        $responses = $this->questionnaireStorageManager->getAllResponsesGivenByUser(Auth::id(), $projectId);
        switch ($responses->count()) {
            case 1:
                return (object)[
                    'badgeName' => 'Bronze Contributor (Level 1)',
                    'html' =>
                        '<p>This is your first questionnaire!</p><p>The Bronze Contributor badge now belongs to you!</p>
                        <img class="gamification-badge bronze" src="' . asset('images/badges/cup.png') . '">
                        <p>Bronze Contributor <span class="level">(Level 1)</span></p>'
                ];
            case 2:
                return (object)[
                    'badgeName' => 'Silver Contributor (Level 2)',
                    'html' =>
                        '<p>This is your second questionnaire!</p><p>The Silver Contributor badge now belongs to you!</p>
                        <img class="gamification-badge silver" src="' . asset('images/badges/cup.png') . '">
                        <p>Silver Contributor <span class="level">(Level 2)</span></p>'
                ];
            case 3:
                return (object)[
                    'badgeName' => null,
                    'html' =>
                        '<p>This is your third questionnaire!</p>
                        <img src="' . asset('images/badges/like.png') . '"><p>Three more left to unlock the Gold Contributor badge!</p>'
                    ];
            case 4:
                return (object)[
                    'badgeName' => null,
                    'html' =>
                        '<p>This is your 4th questionnaire!</p><img src="' . asset('images/badges/like.png') . '">
                        <p>Two more left to unlock the Gold Contributor badge!</p>'
                ];
            case 5:
                return (object)[
                    'badgeName' => null,
                    'html' =>
                        '<p>This is your 5th questionnaire!</p><img src="' . asset('images/badges/like.png') . '">
                        <p>One more left to unlock the Gold Contributor badge!</p><p>Do not give up, you are this close!</p>'
                    ];
            case 6:
                return (object)[
                    'badgeName' => 'Gold Contributor (Level 3)',
                    'html' =>
                        '<p>Congratulations!</p><p>You have unlocked the Gold Contributor badge!</p>
                        <img class="gamification-badge gold" src="' . asset('images/badges/cup.png') . '">
                        <p>Gold Contributor <span class="level">(Level 3)</span></p>'
                    ];
            default:
                return (object)[
                        'badgeName' => null,
                        'html' =>
                            '<p>This is your ' . $responses->count() . 'th questionnaire!</p>
                            <img src="' . asset('images/badges/like.png') . '"><p>Keep up the good work!</p>'
                ];
        }
    }
}