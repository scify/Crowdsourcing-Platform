<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\User;

use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireActionHandler;
use App\BusinessLogicLayer\WebSessionManager;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\User\UserQuestionnaireShareRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserQuestionnaireShareManager {
    public function __construct(protected UserQuestionnaireShareRepository $questionnaireShareRepository,
        protected QuestionnaireRepository $questionnaireRepository,
        protected QuestionnaireActionHandler $questionnaireActionHandler,
        protected UserRepository $userRepository,
        protected WebSessionManager $webSessionManager,
        protected LanguageManager $languageManager
    ) {}

    public function createQuestionnaireShare(int $userId, $questionnaireId) {
        return $this->questionnaireShareRepository->create(['user_id' => $userId, 'questionnaire_id' => $questionnaireId]);
    }

    public function handleQuestionnaireShare(array $parameters, int $referrerId): void {
        $questionnaireId = $parameters['questionnaireId'];
        if ($this->shouldCountQuestionnaireShare($questionnaireId, $referrerId)) {
            $this->webSessionManager->setReferrerId($referrerId);
            $questionnaire = $this->questionnaireRepository->find($questionnaireId);
            if ($questionnaire &&
                ! $this->questionnaireShareRepository->questionnaireShareExists($questionnaire->id, $referrerId)) {
                $lang = $this->languageManager->getLanguageByCode(app()->getLocale());
                $this->createQuestionnaireShare($referrerId, $questionnaire->id);
                $this->questionnaireActionHandler->handleQuestionnaireSharer($questionnaire,
                    $this->userRepository->find($referrerId),
                    $lang);
            }
        }
    }

    protected function shouldCountQuestionnaireShare(int $questionnaireId, int $referrerId): bool {
        return $this->questionnaireRepository->exists(['id' => $questionnaireId])
            && $this->userRepository->exists(['id' => $referrerId])
            && $this->userNotLoggedInOrDifferentThanReferrer($referrerId);
    }

    protected function userNotLoggedInOrDifferentThanReferrer(int $referrerId): bool {
        if (! Auth::check()) {
            return true;
        }

        return Auth::id() !== $referrerId;
    }
}
