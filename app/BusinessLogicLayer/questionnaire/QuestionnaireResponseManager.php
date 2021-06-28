<?php

namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\LanguageManager;
use App\Models\User;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Support\Facades\Auth;

class QuestionnaireResponseManager {

    protected $questionnaireRepository;
    protected $questionnaireResponseRepository;
    protected $languageManager;
    protected $questionnaireActionHandler;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository,
                                LanguageManager $languageManager,
                                QuestionnaireActionHandler $questionnaireActionHandler) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->languageManager = $languageManager;
        $this->questionnaireActionHandler = $questionnaireActionHandler;
    }

    public function getQuestionnaireResponsesForUser(User $user) {
        return $this->questionnaireRepository->getAllResponsesGivenByUser($user->id);
    }

    public function questionnaireResponsesForUserExists($userId) {
        return $this->questionnaireResponseRepository->userResponseExists($userId);
    }

    public function questionnaireResponsesForUserAndQuestionnaireExists($userId, $questionnaireId) {
        return $this->questionnaireResponseRepository->questionnaireResponseExists($userId, $questionnaireId);
    }

    public function storeQuestionnaireResponse($data) {
        $response = json_decode($data['response']);
        $user = Auth::user();
        $questionnaire = $this->questionnaireRepository->find($data['questionnaire_id']);
        if (isset($data['selectedLanguageCode']))
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

}
