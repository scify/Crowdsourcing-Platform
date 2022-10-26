<?php

namespace App\BusinessLogicLayer\gamification;

use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseReferralRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\UserQuestionnaireShareRepository;

class QuestionnaireBadgeProvider {
    protected $questionnaireRepository;
    protected $questionnaireResponseRepository;
    protected $userQuestionnaireShareRepository;
    protected $questionnaireResponseReferralRepository;
    protected $platformWideGamificationBadgesProvider;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository,
                                UserQuestionnaireShareRepository $userQuestionnaireShareRepository,
                                QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->userQuestionnaireShareRepository = $userQuestionnaireShareRepository;
        $this->questionnaireResponseReferralRepository = $questionnaireResponseReferralRepository;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
    }

    public function getNextUnlockableBadgeToShowForQuestionnaire(Questionnaire $questionnaire, int $userId, array $questionnaireIdsUserHasAnsweredTo): GamificationBadge {
        if (!$this->userHasAchievedContributorBadgeForQuestionnaire($questionnaire->id, $questionnaireIdsUserHasAnsweredTo)) {
            return new ContributorBadge(count($questionnaireIdsUserHasAnsweredTo), count($questionnaireIdsUserHasAnsweredTo));
        }

        if (!$this->userHasAchievedCommunicatorBadgeForQuestionnaire($questionnaire, $userId)) {
            return new CommunicatorBadge($this->userQuestionnaireShareRepository->
            getUserQuestionnaireSharesForUserForQuestionnaire($questionnaire->id, $userId),
                $this->platformWideGamificationBadgesProvider->userHasAchievedCommunicatorBadge($userId));
        }

        if (!$this->userHasAchievedInfluencerBadgeForQuestionnaire($questionnaire, $userId)) {
            return new InfluencerBadge($this->questionnaireResponseReferralRepository->
            getQuestionnaireReferralsForUserForQuestionnaire($questionnaire->id, $userId)->count(),
                $this->platformWideGamificationBadgesProvider->userHasAchievedInfluencerBadge($userId));
        }

        return new AllBadgesCompletedBadge();
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
