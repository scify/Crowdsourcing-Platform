<?php

namespace App\BusinessLogicLayer\User;

use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireActionHandler;
use App\BusinessLogicLayer\WebSessionManager;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\User\UserQuestionnaireShareRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserQuestionnaireShareManager {
    protected $questionnaireShareRepository;
    protected $questionnaireRepository;
    protected $questionnaireActionHandler;
    protected $userRepository;
    protected $webSessionManager;

    public function __construct(UserQuestionnaireShareRepository $questionnaireShareRepository,
        QuestionnaireRepository $questionnaireRepository,
        QuestionnaireActionHandler $questionnaireActionHandler,
        UserRepository $userRepository,
        WebSessionManager $webSessionManager,
        LanguageManager $languageManager
    ) {
        $this->questionnaireShareRepository = $questionnaireShareRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireActionHandler = $questionnaireActionHandler;
        $this->userRepository = $userRepository;
        $this->webSessionManager = $webSessionManager;
        $this->languageManager = $languageManager;
    }

    public function createQuestionnaireShare(int $userId, $questionnaireId) {
        return $this->questionnaireShareRepository->create(['user_id' => $userId, 'questionnaire_id' => $questionnaireId]);
    }

    public function handleQuestionnaireShare(array $parameters, int $referrerId) {
        $questionnaireId = $parameters['questionnaireId'];
        if ($this->shouldCountQuestionnaireShare($questionnaireId, $referrerId)) {
            $this->webSessionManager->setReferrerId($referrerId);
            $questionnaire = $this->questionnaireRepository->find($questionnaireId);
            if ($questionnaire &&
                !$this->questionnaireShareRepository->questionnaireShareExists($questionnaire->id, $referrerId)) {
                $lang = $this->languageManager->getLanguageByCode(app()->getLocale());
                $this->createQuestionnaireShare($referrerId, $questionnaire->id);
                $this->questionnaireActionHandler->handleQuestionnaireSharer($questionnaire,
                    $this->userRepository->find($referrerId),
                    $lang);
            }
        }
    }

    protected function shouldCountQuestionnaireShare(int $questionnaireId, int $referrerId) {
        return $this->questionnaireRepository->exists(['id' => $questionnaireId])
            && $this->userRepository->exists(['id' => $referrerId])
            && $this->userNotLoggedInOrDifferentThanReferrer($referrerId);
    }

    protected function userNotLoggedInOrDifferentThanReferrer(int $referrerId) {
        if (!Auth::check()) {
            return true;
        }

        return Auth::id() !== $referrerId;
    }
}
