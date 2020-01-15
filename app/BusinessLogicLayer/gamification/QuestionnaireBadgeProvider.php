<?php


namespace App\BusinessLogicLayer\gamification;


use App\Models\Questionnaire;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireResponseReferralRepository;
use App\Repository\QuestionnaireResponseRepository;
use App\Repository\UserQuestionnaireShareRepository;

class QuestionnaireBadgeProvider {

    protected $questionnaireRepository;
    protected $questionnaireResponseRepository;
    protected $userQuestionnaireShareRepository;
    protected $questionnaireResponseReferralRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository,
                                UserQuestionnaireShareRepository $userQuestionnaireShareRepository,
                                QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->userQuestionnaireShareRepository = $userQuestionnaireShareRepository;
        $this->questionnaireResponseReferralRepository = $questionnaireResponseReferralRepository;
    }


    public function getNextUnlockableBadgeToShowForQuestionnaire(Questionnaire $questionnaire, int $userId): GamificationBadge {
        if(!$this->userHasAchievedContributorBadgeForQuestionnaire($questionnaire, $userId))
            return new ContributorBadge($this->questionnaireRepository->
            getAllResponsesGivenByUser($userId)->count());

        if(!$this->userHasAchievedCommunicatorBadgeForQuestionnaire($questionnaire, $userId))
            return new CommunicatorBadge($this->userQuestionnaireShareRepository->
            getUserQuestionnaireSharesForUserForQuestionnaire($questionnaire->id, $userId)->count(), $userId);

        if(!$this->userHasAchievedInfluencerBadgeForQuestionnaire($questionnaire, $userId))
            return new InfluencerBadge($this->questionnaireResponseReferralRepository->
            getQuestionnaireReferralsForUserForQuestionnaire($questionnaire->id, $userId)->count());

        return null;
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
