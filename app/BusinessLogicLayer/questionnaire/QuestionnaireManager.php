<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\WebSessionManager;
use App\Models\Questionnaire\Questionnaire;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireTranslationRepository;
use App\Repository\Questionnaire\Reports\QuestionnaireReportRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseAnswerRepository;
use App\Repository\UserRepository;
use App\Utils\Translator;
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
    protected $crowdSourcingProjectRepository;
    protected $questionnaireLanguageManager;
    protected $crowdSourcingProjectQuestionnaireRepository;

    public function __construct(QuestionnaireRepository                     $questionnaireRepository,
                                LanguageManager                             $languageManager,
                                Translator                                  $translator,
                                WebSessionManager                           $webSessionManager,
                                UserRepository                              $userRepository,
                                QuestionnaireResponseReferralManager        $questionnaireResponseReferralManager,
                                QuestionnaireReportRepository               $questionnaireReportRepository,
                                QuestionnaireResponseAnswerRepository       $questionnaireResponseAnswerRepository,
                                QuestionnaireTranslationRepository          $questionnaireTranslationRepository,
                                CrowdSourcingProjectAccessManager           $crowdSourcingProjectAccessManager,
                                CrowdSourcingProjectRepository              $crowdSourcingProjectRepository,
                                QuestionnaireLanguageManager                $questionnaireLanguageManager,
                                CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository) {
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
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->questionnaireLanguageManager = $questionnaireLanguageManager;
        $this->crowdSourcingProjectQuestionnaireRepository = $crowdSourcingProjectQuestionnaireRepository;
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments) {
        $comments = is_null($comments) ? "" : $comments;
        $this->questionnaireRepository->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function storeQuestionnaire($data) {
        $questionnaire = $this->questionnaireRepository->saveNewQuestionnaire(
            $data['title'], $data['description'],
            $data['goal'], $data['language'], $data['content'],
            $data['statistics_page_visibility_lkp_id']
        );
        $this->storeRelatedDataForQuestionnaire($questionnaire, $data);
        return $questionnaire;
    }

    public function updateQuestionnaire($id, $data) {
        $questionnaire = $this->questionnaireRepository->updateQuestionnaire($id,
            $data['title'], $data['description'],
            $data['goal'], $data['language'], $data['content'],
            $data['statistics_page_visibility_lkp_id']);
        $this->storeRelatedDataForQuestionnaire($questionnaire, $data);
        return $questionnaire;
    }

    protected function storeRelatedDataForQuestionnaire(Questionnaire $questionnaire, array $data) {
        $this->questionnaireLanguageManager->saveLanguagesForQuestionnaire($data['lang_codes'], $questionnaire->id);
        $this->crowdSourcingProjectQuestionnaireRepository->setQuestionnaireToProjects($questionnaire->id, $data['project_ids']);
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
        $this->questionnaireRepository->saveNewQuestionnaireStatusHistory($questionnaireId, 2, 'Before translating');
        $this->questionnaireTranslationRepository->storeQuestionnaireTranslations($questionnaireId, json_decode($translations));
    }

//    private function storeToAllQuestionnaireRelatedTables($questionnaireId, $data) {
//        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
//        $index = 1;
//        foreach ($questions as $question) {
//            $questionTitle = isset($question->title) ? $question->title : $question->name;
//            $questionType = $question->type;
//            $storedQuestion = $this->questionnaireRepository->saveNewQuestion($questionnaireId, $questionTitle, $questionType, $question->name, $question->guid, $index);
//            if ($questionType === 'html')
//                $this->questionnaireRepository->saveNewHtmlElement($storedQuestion->id, $question->html);
//            $this->storeAllAnswers($question, $storedQuestion->id);
//            $index++;
//        }
//    }

//    private function updateAllQuestionnaireRelatedTables($questionnaireId, $data) {
//        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
//        $this->questionnaireRepository->updateAllQuestionnaireRelatedTables($questionnaireId, $questions);
//    }

//    private function extractDataFromQuestionnaireJson($content) {
//        $questionnaire = json_decode($content);
//        $allQuestions = [];
//        foreach ($questionnaire->pages as $page) {
//            if (isset($page->elements))
//                $allQuestions = array_merge($allQuestions, $page->elements);
//        }
//        return $allQuestions;
//    }
//
//    private function storeAllAnswers($question, $questionId) {
//        if (isset($question->choices)) {
//            foreach ($question->choices as $choice) {
//
//                if (isset($choice->name))
//                    $answer = $choice->name;
//                else if (isset($choice->text))
//                    $answer = $choice->text;
//                else
//                    $answer = $choice;
//
//                $value = isset($choice->value) ? $choice->value : $choice;
//                $this->questionnaireRepository->saveNewAnswer($questionId, $answer, $value, $choice->guid);
//            }
//        }
//
//        if (isset($question->hasOther) && $question->hasOther)
//            $this->questionnaireRepository->saveNewOtherAnswer($questionId, $question);
//    }

    public function markQuestionnaireTranslation(int $questionnaireId, int $langId, bool $markHuman) {
        $questionnaireLanguage = $this->questionnaireTranslationRepository->getQuestionnaireLanguage($questionnaireId, $langId);
        if (!$questionnaireLanguage)
            throw new ResourceNotFoundException("Questionnaire Language not found. Questionnaire Id: " . $questionnaireId . " Lang id: " . $langId);
        $questionnaireLanguage->machine_generated_translation = !$markHuman;
        $questionnaireLanguage->save();
    }

//    public function deleteQuestionnaireTranslation($questionnaireId, $langId) {
//        $questionnaireLanguage = $this->questionnaireTranslationRepository->getQuestionnaireLanguage($questionnaireId, $langId);
//        if (!$questionnaireLanguage)
//            throw new ResourceNotFoundException("Questionnaire Language not found. Questionnaire Id: " . $questionnaireId . " Lang id: " . $langId);
//        $this->deleteTranslatedQuestionTitles($this->questionnaireRepository->find($questionnaireId), $this->languageManager->getLanguage($langId));
//        $this->questionnaireTranslationRepository->deleteQuestionnaireTranslation($questionnaireLanguage);
//    }

//    private function deleteTranslatedQuestionTitles(Questionnaire $questionnaire, Language $language) {
//        $questionnaireJSONObj = json_decode($questionnaire->questionnaire_json);
//        foreach ($questionnaireJSONObj->pages as $page) {
//            if (isset($page->elements))
//                foreach ($page->elements as $question) {
//                    if (isset($question->title->{$language->language_code}))
//                        unset($question->title->{$language->language_code});
//                    if (isset($question->choices))
//                        foreach ($question->choices as $choice)
//                            if (isset($choice->text->{$language->language_code}))
//                                unset($choice->text->{$language->language_code});
//                    if (isset($question->otherText))
//                        if (isset($question->otherText->{$language->language_code}))
//                            unset($question->otherText->{$language->language_code});
//                    if (isset($question->html))
//                        if (isset($question->html->{$language->language_code}))
//                            unset($question->html->{$language->language_code});
//                }
//        }
//        $questionnaire->questionnaire_json = json_encode($questionnaireJSONObj);
//        $questionnaire->save();
//    }

    public function shouldShowLinkForQuestionnaire($questionnaire): bool {
        return in_array($questionnaire->status_id, [QuestionnaireStatusLkp::DRAFT, QuestionnaireStatusLkp::PUBLISHED]);
    }

    public function getQuestionnaireURL($projectSlug, $questionnaireId): string {
        return url('/' . trim($projectSlug)) . '?open=1&questionnaireId=' . $questionnaireId;
    }
}
