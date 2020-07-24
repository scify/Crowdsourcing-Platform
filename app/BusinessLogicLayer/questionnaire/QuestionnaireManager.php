<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\BusinessLogicLayer\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\WebSessionManager;
use App\Models\Language;
use App\Models\Questionnaire;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\Questionnaire\Reports\QuestionnaireReportRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseAnswerRepository;
use App\Repository\Questionnaire\QuestionnaireTranslationRepository;
use App\Repository\UserRepository;
use App\Utils\Translator;
use Illuminate\Support\Facades\Auth;
use JsonSchema\Exception\ResourceNotFoundException;

class QuestionnaireManager {
    protected $questionnaireRepository;
    protected $languageManager;
    protected $translator;
    protected $webSessionManager;
    protected $questionnaireResponseReferralManager;
    protected $userRepository;
    protected $questionnaireReportRepository;
    protected $questionnaireResponseAnswerRepository;
    protected $questionnaireTranslationRepository;
    protected $crowdSourcingProjectAccessManager;
    protected $questionnaireActionHandler;
    protected $crowdSourcingProjectRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                LanguageManager $languageManager,
                                Translator $translator,
                                WebSessionManager $webSessionManager,
                                UserRepository $userRepository,
                                QuestionnaireResponseReferralManager $questionnaireResponseReferralManager,
                                QuestionnaireReportRepository $questionnaireReportRepository,
                                QuestionnaireResponseAnswerRepository $questionnaireResponseAnswerRepository,
                                QuestionnaireTranslationRepository $questionnaireTranslationRepository,
                                CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager,
                                QuestionnaireActionHandler $questionnaireActionHandler,
                                CrowdSourcingProjectRepository $crowdSourcingProjectRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->languageManager = $languageManager;
        $this->translator = $translator;
        $this->webSessionManager = $webSessionManager;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->userRepository = $userRepository;
        $this->questionnaireReportRepository = $questionnaireReportRepository;
        $this->questionnaireResponseAnswerRepository = $questionnaireResponseAnswerRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        $this->crowdSourcingProjectAccessManager = $crowdSourcingProjectAccessManager;
        $this->questionnaireActionHandler = $questionnaireActionHandler;
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments) {
        $comments = is_null($comments) ? "" : $comments;
        $this->questionnaireRepository->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function createNewQuestionnaire($data) {
        $projectTheQuestionnaireBelongsTo = $this->crowdSourcingProjectRepository->find($data['project']);
        // here we need to set the prerequisite order of the questionnaire equal to the number of questionnaires + 1.
        $numOfQuestionnaires = $projectTheQuestionnaireBelongsTo->questionnaires->count();
        $questionnaire = $this->questionnaireRepository->saveNewQuestionnaire(
            $data['title'], $data['description'],
            $data['goal'], $data['language'],
            $data['project'], $data['content'],
            $numOfQuestionnaires + 1,
            $data['statistics_page_visibility_lkp_id']
        );
        $this->storeToAllQuestionnaireRelatedTables($questionnaire->id, $data);
    }

    public function updateQuestionnaire($id, $data) {
        $this->questionnaireRepository->updateQuestionnaire($id,
            $data['title'], $data['description'],
            $data['goal'], $data['language'],
            $data['project'], $data['content'],
            $data['prerequisite_order'], $data['statistics_page_visibility_lkp_id']);
        $this->updateAllQuestionnaireRelatedTables($id, $data);
    }

    public function storeQuestionnaireResponse($data) {
        $response = json_decode($data['response']);
        $user = Auth::user();
        $questionnaire = $this->questionnaireRepository->find($data['questionnaire_id']);
        if(isset($data['selectedLanguageCode']))
            $language = $this->languageManager->getLanguageByCode($data['selectedLanguageCode']);
        else
            $language = $this->languageManager->getLanguage($questionnaire->default_language_id);

        $this->questionnaireRepository->saveNewQuestionnaireResponse(
            $data['questionnaire_id'],
            $response,
            $user->id,
            $data['response'],
            $language->id
        );
        $this->questionnaireActionHandler->handleQuestionnaireContributor($questionnaire, $user);
        // if the user got invited by another user to answer the questionnaire, also award the referrer user.
        $this->questionnaireActionHandler->handleQuestionnaireReferrer($questionnaire, $user);
    }

    public function getAutomaticTranslationForString($languageCodeToTranslateTo, $text) {
        return $this->translator->translateTexts([$text], $languageCodeToTranslateTo);
    }

    public function getAutomaticTranslations($languageCodeToTranslateTo, $ids, $texts) {
        $translations = [];
        $translatedTexts = $this->translator->translateTexts($texts, $languageCodeToTranslateTo);
        if ($translatedTexts)
            foreach ($ids as $key => $id)
                $translations[$id] = str_replace('&quot;', '"', $translatedTexts[$key]);
        return $translations;
    }

    public function storeQuestionnaireTranslations($questionnaireId, $translations) {
        $this->questionnaireTranslationRepository->storeQuestionnaireTranslations($questionnaireId, json_decode($translations));
    }

    private function storeToAllQuestionnaireRelatedTables($questionnaireId, $data) {
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

    private function updateAllQuestionnaireRelatedTables($questionnaireId, $data) {
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        $this->questionnaireRepository->updateAllQuestionnaireRelatedTables($questionnaireId, $questions);
    }

    private function extractDataFromQuestionnaireJson($content) {
        $questionnaire = json_decode($content);
        $allQuestions = [];
        foreach ($questionnaire->pages as $page) {
            if (isset($page->elements))
                $allQuestions = array_merge($allQuestions, $page->elements);
        }
        return $allQuestions;
    }

    private function storeAllAnswers($question, $questionId) {
        if (isset($question->choices)) {
            foreach ($question->choices as $choice) {

                if (isset($choice->name))
                    $answer = $choice->name;
                else if (isset($choice->text))
                    $answer = $choice->text;
                else
                    $answer = $choice;

                $value = isset($choice->value) ? $choice->value : $choice;
                $this->questionnaireRepository->saveNewAnswer($questionId, $answer, $value, $choice->guid);
            }
        }

        if (isset($question->hasOther) && $question->hasOther)
            $this->questionnaireRepository->saveNewOtherAnswer($questionId, $question);
    }

    public function markQuestionnaireTranslation(int $questionnaireId, int $langId, bool $markHuman) {
        $questionnaireLanguage = $this->questionnaireTranslationRepository->getQuestionnaireLanguage($questionnaireId, $langId);
        if (!$questionnaireLanguage)
            throw new ResourceNotFoundException("Questionnaire Language not found. Questionnaire Id: " . $questionnaireId . " Lang id: " . $langId);
        $questionnaireLanguage->machine_generated_translation = !$markHuman;
        $questionnaireLanguage->save();
    }

    public function deleteQuestionnaireTranslation($questionnaireId, $langId) {
        $questionnaireLanguage = $this->questionnaireTranslationRepository->getQuestionnaireLanguage($questionnaireId, $langId);
        if (!$questionnaireLanguage)
            throw new ResourceNotFoundException("Questionnaire Language not found. Questionnaire Id: " . $questionnaireId . " Lang id: " . $langId);
        $this->deleteTranslatedQuestionTitles($this->questionnaireRepository->find($questionnaireId), $this->languageManager->getLanguage($langId));
        $this->questionnaireTranslationRepository->deleteQuestionnaireTranslation($questionnaireLanguage);
    }

    private function deleteTranslatedQuestionTitles(Questionnaire $questionnaire, Language $language) {
        $questionnaireJSONObj = json_decode($questionnaire->questionnaire_json);
        foreach ($questionnaireJSONObj->pages as $page) {
            if (isset($page->elements))
                foreach ($page->elements as $question) {
                    if (isset($question->title->{$language->language_code}))
                        unset($question->title->{$language->language_code});
                    if (isset($question->choices))
                        foreach ($question->choices as $choice)
                            if (isset($choice->text->{$language->language_code}))
                                unset($choice->text->{$language->language_code});
                    if (isset($question->otherText))
                        if (isset($question->otherText->{$language->language_code}))
                            unset($question->otherText->{$language->language_code});
                    if (isset($question->html))
                        if (isset($question->html->{$language->language_code}))
                            unset($question->html->{$language->language_code});
                }
        }
        $questionnaire->questionnaire_json = json_encode($questionnaireJSONObj);
        $questionnaire->save();
    }
}
