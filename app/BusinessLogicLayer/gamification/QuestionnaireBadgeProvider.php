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


    public function getNextUnlockableBadgeToShowForQuestionnaire(Questionnaire $questionnaire, int $userId): GamificationBadge {

        if(!$this->userHasAchievedContributorBadgeForQuestionnaire($questionnaire, $userId))
            return new ContributorBadge($this->questionnaireRepository->
            getAllResponsesGivenByUser($userId)->count(), $this->platformWideGamificationBadgesProvider->userHasAchievedContributorBadge($userId));

        if(!$this->userHasAchievedCommunicatorBadgeForQuestionnaire($questionnaire, $userId))
            return new CommunicatorBadge($this->userQuestionnaireShareRepository->
            getUserQuestionnaireSharesForUserForQuestionnaire($questionnaire->id, $userId)->count(),
            $this->platformWideGamificationBadgesProvider->userHasAchievedCommunicatorBadge($userId));

        if(!$this->userHasAchievedInfluencerBadgeForQuestionnaire($questionnaire, $userId))
            return new InfluencerBadge($this->questionnaireResponseReferralRepository->
            getQuestionnaireReferralsForUserForQuestionnaire($questionnaire->id, $userId)->count(),
            $this->platformWideGamificationBadgesProvider->userHasAchievedInfluencerBadge($userId));

        return new AllBadgesCompletedBadge();
    }

    protected function userHasAchievedContributorBadgeForQuestionnaire(Questionnaire $questionnaire, int $userId) {
        return $this->questionnaireResponseRepository->questionnaireResponseExists($questionnaire->id, $userId);
    }

    protected function userHasAchievedCommunicatorBadgeForQuestionnaire(Questionnaire $questionnaire, int $userId) {
        return $this->userQuestionnaireShareRepository->questionnaireShareExists($questionnaire->id, $userId);
    }

    protected function userHasAchievedInfluencerBadgeForQuestionnaire(Questionnaire $questionnaire, int $userId) {
        return $this->questionnaireResponseReferralRepository->questionnaireReferralByUserExists($questionnaire->id, $userId);
    }

}
