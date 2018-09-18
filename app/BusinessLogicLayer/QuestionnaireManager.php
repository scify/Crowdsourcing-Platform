<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 3:48 PM
 */

namespace App\BusinessLogicLayer;

use App\BusinessLogicLayer\gamification\GamificationManager;
use App\Models\ViewModels\CreateEditQuestionnaire;
use App\Models\ViewModels\ManageQuestionnaires;
use App\Models\ViewModels\QuestionnaireTranslation;
use App\Models\ViewModels\reports\QuestionnaireReportResults;
use App\Notifications\QuestionnaireResponded;
use App\Notifications\ReferredQuestionnaireAnswered;
use App\Repository\QuestionnaireReportRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireResponseAnswerRepository;
use App\Repository\UserRepository;
use App\Utils\Translator;
use Illuminate\Support\Facades\Auth;
use JsonSchema\Exception\ResourceNotFoundException;
use Ramsey\Uuid\Exception\UnsupportedOperationException;

class QuestionnaireManager
{
    private $questionnaireRepository;
    private $languageManager;
    private $translator;
    private $gamificationManager;
    private $webSessionManager;
    private $questionnaireResponseReferralManager;
    private $userRepository;
    private $questionnaireReportRepository;
    private $questionnaireResponseAnswerRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                LanguageManager $languageManager,
                                Translator $translator,
                                GamificationManager $gamificationManager,
                                WebSessionManager $webSessionManager,
                                UserRepository $userRepository,
                                QuestionnaireResponseReferralManager $questionnaireResponseReferralManager,
                                QuestionnaireReportRepository $questionnaireReportRepository,
                                QuestionnaireResponseAnswerRepository $questionnaireResponseAnswerRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->languageManager = $languageManager;
        $this->translator = $translator;
        $this->gamificationManager = $gamificationManager;
        $this->webSessionManager = $webSessionManager;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->userRepository = $userRepository;
        $this->questionnaireReportRepository = $questionnaireReportRepository;
        $this->questionnaireResponseAnswerRepository = $questionnaireResponseAnswerRepository;
    }

    public function getCreateEditQuestionnaireViewModel($id)
    {
        $questionnaire = null;
        $title = "Create Questionnaire";
        if (!is_null($id)) {
            $questionnaire = $this->questionnaireRepository->findQuestionnaire($id);
            $title = "Edit Questionnaire";
        }
        $languages = $this->languageManager->getAllLanguages();
        return new CreateEditQuestionnaire($questionnaire, $languages, $title);
    }

    public function getAllQuestionnairesForProjectViewModel($projectId)
    {
        $questionnaires = $this->questionnaireRepository->getAllQuestionnairesForProjectWithAvailableTranslations($projectId);
        $availableStatuses = $this->questionnaireRepository->getAllQuestionnaireStatuses();
        return new ManageQuestionnaires($questionnaires, $availableStatuses, $projectId);
    }

    public function getResponsesGivenByUser($userId) {
        return $this->questionnaireRepository->getAllResponsesGivenByUser($userId);
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments)
    {
        $comments = is_null($comments) ? "" : $comments;
        $this->questionnaireRepository->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function createNewQuestionnaire($data)
    {
        $questionnaire = $this->questionnaireRepository->saveNewQuestionnaire(
            $data['title'], $data['description'], $data['goal'], $data['language'], $data['project'], $data['content']
        );
        $this->storeToAllQuestionnaireRelatedTables($questionnaire->id, $data);
    }

    public function updateQuestionnaire($id, $data)
    {
        $this->questionnaireRepository->updateQuestionnaire($id, $data['title'], $data['description'],
            $data['goal'], $data['language'], $data['project'], $data['content']);
        $this->updateAllQuestionnaireRelatedTables($id, $data);
    }

    public function storeQuestionnaireResponse($data) {
        $response = json_decode($data['response']);
        $user = Auth::user();
        $questionnaire = $this->questionnaireRepository->findQuestionnaire($data['questionnaire_id']);
        $this->questionnaireRepository->saveNewQuestionnaireResponse($data['questionnaire_id'], $response, $user->id, $data['response']);
        $this->awardContributorBadgeAndNotifyUser($questionnaire, $user);
        // if the user got invited by another user to answer the questionnaire, also award the referrer user.
        $this->handleQuestionnaireReferrer($questionnaire, $user);
    }

    private function awardContributorBadgeAndNotifyUser($questionnaire, $user) {
        $contributorBadge = $this->gamificationManager->getContributorBadge($user->id);
        $user->notify(new QuestionnaireResponded($questionnaire, $contributorBadge, $this->gamificationManager->getBadgeViewModel($contributorBadge)));
    }

    private function handleQuestionnaireReferrer($questionnaire, $user) {
        $referrerId = $this->webSessionManager->getReferredId();
        if($referrerId) {
            $referrer = $this->userRepository->getUser($referrerId);
            if($referrer) {
                $this->questionnaireResponseReferralManager->createQuestionnaireResponseReferral($questionnaire->id, $user->id, $referrer->id);
                $influencerBadge = $this->gamificationManager->getInfluencerBadge($referrer->id, $questionnaire);
                $referrer->notify(new ReferredQuestionnaireAnswered($questionnaire, $influencerBadge, $this->gamificationManager->getBadgeViewModel($influencerBadge)));
                $this->webSessionManager->setReferrerId(null);
            }
        }
    }

    public function getAutomaticTranslationForString($languageCodeToTranslateTo, $text){
        return $this->translator->translateTexts([$text], $languageCodeToTranslateTo);
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
        $questionnaire = $this->questionnaireRepository->findQuestionnaire($questionnaireId);
        $allLanguages = $this->languageManager->getAllLanguages()->groupBy('id');
        $defaultLanguage = $allLanguages->pull($questionnaire->default_language_id);
        $allLanguages = $this->transformAllLanguagesToArray($allLanguages);
        $questionnaireTranslations = $this->questionnaireRepository->getQuestionnaireTranslationsGroupedByLanguageAndQuestion($questionnaireId);
        $questionnaireLanguages = $this->questionnaireRepository->getQuestionnaireAvailableLanguages($questionnaireId);
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
        return new QuestionnaireTranslation($questionnaireTranslations, $questionnaireLanguages, $questionnaire, $allLanguages, $defaultLanguage[0]);
    }

    public function storeQuestionnaireTranslations($questionnaireId, $translations)
    {
        $this->questionnaireRepository->storeQuestionnaireTranslations($questionnaireId, json_decode($translations));
    }

    private function storeToAllQuestionnaireRelatedTables($questionnaireId, $data)
    {
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        $index = 1;
        foreach ($questions as $question) {
            $questionTitle = isset($question->title) ? $question->title : $question->name;
            $questionType = $question->type;
            $storedQuestion = $this->questionnaireRepository->saveNewQuestion($questionnaireId, $questionTitle, $questionType, $question->name, $question->guid, $index);
            if ($questionType === 'html')
                $this->questionnaireRepository->saveNewHtmlElement($storedQuestion->id, $question->html);
            $this->storeAllAnswers($question, $storedQuestion->id);
            $index++;
        }
    }

    private function updateAllQuestionnaireRelatedTables($questionnaireId, $data)
    {
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        $this->questionnaireRepository->updateAllQuestionnaireRelatedTables($questionnaireId, $questions);
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
            foreach ($question->choices as $choice) {

                if (isset($choice->name))
                    $answer = $choice->name;
                else if (isset($choice->text))
                    $answer  = $choice->text;
                else
                    $answer  = $choice;

                $value = isset($choice->value) ? $choice->value : $choice;
                $this->questionnaireRepository->saveNewAnswer($questionId, $answer, $value, $choice->guid);
            }
        }

        if (isset($question->hasOther) && $question->hasOther)
            $this->questionnaireRepository->saveNewOtherAnswer($questionId, $question);
    }

    private function transformAllLanguagesToArray($allLanguages)
    {
        $result = [];
        foreach ($allLanguages as $language) {
            array_push($result, $language[0]);
        }
        return $result;
    }

    public function getQuestionnaireReportViewModel(array $input) {
        $questionnaireId = $input['questionnaireId'];
        $usersRows = $this->questionnaireReportRepository->getReportDataForUsers($questionnaireId);
        $answersRows = collect($this->questionnaireReportRepository->getReportDataForAnswers($questionnaireId));
        $answerTextRows = $this->questionnaireResponseAnswerRepository->getResponseTextDataForQuestionnaire($questionnaireId);
        foreach ($answersRows as $answersRow)
            $answersRow->answer_texts = $answerTextRows->where('question_id', $answersRow->question_id)->where('answer_id', $answersRow->answer_id)->values();
        return new QuestionnaireReportResults($usersRows, $answersRows);
    }

    public function markQuestionnaireTranslation(int $questionnaireId, int $langId, bool $markHuman) {
        $questionnaireLanguage = $this->questionnaireRepository->getQuestionnaireLanguage($questionnaireId, $langId);
        if(!$questionnaireLanguage)
            throw new ResourceNotFoundException("Questionnaire Language not found. Questionnaire Id: " . $questionnaireId . " Lang id: " . $langId);
        $questionnaireLanguage->machine_generated_translation = !$markHuman;
        $questionnaireLanguage->save();
    }
}