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
use JsonSchema\Exception\ResourceNotFoundException;

class QuestionnaireManager {
    protected $questionnaireRepository;
    protected $languageManager;
    protected $questionnaireTranslator;
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
                                QuestionnaireTranslator                     $questionnaireTranslator,
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
        $this->questionnaireTranslator = $questionnaireTranslator;
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

    public function markQuestionnaireTranslation(int $questionnaireId, int $langId, bool $markHuman) {
        $questionnaireLanguage = $this->questionnaireTranslationRepository->getQuestionnaireLanguage($questionnaireId, $langId);
        if (!$questionnaireLanguage)
            throw new ResourceNotFoundException("Questionnaire Language not found. Questionnaire Id: " . $questionnaireId . " Lang id: " . $langId);
        $questionnaireLanguage->machine_generated_translation = !$markHuman;
        $questionnaireLanguage->save();
    }

    public function shouldShowLinkForQuestionnaire($questionnaire): bool {
        return in_array($questionnaire->status_id, [QuestionnaireStatusLkp::DRAFT, QuestionnaireStatusLkp::PUBLISHED]);
    }

    public function getQuestionnaireURL($projectSlug, $questionnaireId): string {
        return url('/' . trim($projectSlug)) . '?open=1&questionnaireId=' . $questionnaireId;
    }

    public function translateQuestionnaireToLocales(string $questionnaire_json, array $locales): string {
        return $this->questionnaireTranslator->translateQuestionnaireJSONToLocales($questionnaire_json, $locales);
    }
}
