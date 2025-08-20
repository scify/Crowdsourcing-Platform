<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Gamification;

use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseReferralRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\User\UserQuestionnaireShareRepository;

class QuestionnaireBadgeProvider {
    public function __construct(protected QuestionnaireRepository $questionnaireRepository, protected QuestionnaireResponseRepository $questionnaireResponseRepository, protected UserQuestionnaireShareRepository $userQuestionnaireShareRepository, protected QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository, protected PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider) {}

    public function getNextBadgeToUnlockForQuestionnaire(Questionnaire $questionnaire, int $userId, array $questionnaireIdsUserHasAnsweredTo): GamificationBadge {
        if (! $this->userHasAchievedContributorBadgeForQuestionnaire($questionnaire->id, $questionnaireIdsUserHasAnsweredTo)) {
            return new ContributorBadge(count($questionnaireIdsUserHasAnsweredTo), $questionnaireIdsUserHasAnsweredTo !== []);
        }

        if (! $this->userHasAchievedCommunicatorBadgeForQuestionnaire($questionnaire, $userId)) {
            return new CommunicatorBadge($this->userQuestionnaireShareRepository->
            getUserQuestionnaireSharesForUserForQuestionnaire($questionnaire->id, $userId),
                $this->platformWideGamificationBadgesProvider->userHasAchievedCommunicatorBadge($userId));
        }

        if (! $this->userHasAchievedInfluencerBadgeForQuestionnaire($questionnaire, $userId)) {
            return new InfluencerBadge($this->questionnaireResponseReferralRepository->
            getQuestionnaireReferralsForUserForQuestionnaire($questionnaire->id, $userId)->count(),
                $this->platformWideGamificationBadgesProvider->userHasAchievedInfluencerBadge($userId));
        }

        return new AllBadgesCompletedBadge;
    }

    protected function userHasAchievedContributorBadgeForQuestionnaire(int $questionnaire_id, array $questionnaireIdsUserHasAnsweredTo): bool {
        return in_array($questionnaire_id, $questionnaireIdsUserHasAnsweredTo);
    }

    protected function userHasAchievedCommunicatorBadgeForQuestionnaire(Questionnaire $questionnaire, int $userId) {
        return $this->userQuestionnaireShareRepository->questionnaireShareExists($questionnaire->id, $userId);
    }

    protected function userHasAchievedInfluencerBadgeForQuestionnaire(Questionnaire $questionnaire, int $userId) {
        return $this->questionnaireResponseReferralRepository->questionnaireReferralByUserExists($questionnaire->id, $userId);
    }
}
