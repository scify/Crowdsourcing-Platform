<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\QuestionnaireAnswerManager;
use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Models\ViewModels\GamificationBadgesWithLevels;
use App\Models\ViewModels\GamificationNextStep;
use App\Models\ViewModels\QuestionnaireSocialShareButtons;
use App\Notifications\QuestionnaireShared;
use App\Notifications\ReferredQuestionnaireAnswered;
use App\Repository\QuestionnaireRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GamificationManager {

    private $questionnaireRepository;
    private $questionnaireShareManager;
    private $questionnaireResponseReferralManager;
    private $crowdSourcingProjectManager;
    private $questionnaireAnswerManager;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                CrowdSourcingProjectManager $crowdSourcingProjectManager,
                                QuestionnaireResponseReferralManager $questionnaireResponseReferralManager,
                                QuestionnaireAnswerManager $questionnaireAnswerManager) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->questionnaireAnswerManager = $questionnaireAnswerManager;
    }

    public function getGamificationBadgesForUser(int $userId) {
        return new Collection([
            $this->getContributorBadge($userId),
            $this->getCommunicatorBadge($userId),
            $this->getInfluencerBadge($userId, $this->crowdSourcingProjectManager->getActiveQuestionnaireForProject())
        ]);
    }

    public function getGamificationBadgesViewModels(Collection $badges) {
        $badgesWithLevelsCollection = new Collection();
        foreach ($badges as $badge) {
            $badgesWithLevelsCollection->push($this->getBadgeViewModel($badge));
        }
        return new GamificationBadgesWithLevels($badgesWithLevelsCollection, $this->calculateTotalGamificationPoints($badgesWithLevelsCollection));
    }

    private function calculateTotalGamificationPoints(Collection $badgesWithLevelsCollection) {
        $totalPoints = 0;
        foreach ($badgesWithLevelsCollection as $badge) {
            $totalPoints += $badge->level;
        }
        return $totalPoints;
    }

    public function getBadgeViewModel(GamificationBadge $gamificationBadge) {
        return new GamificationBadgeVM($gamificationBadge);
    }

    public function userHasAchievedBadge(Collection $badges, $badgeId) {
        foreach ($badges as $badge) {
            if($badge->badgeID == $badgeId && $badge->level > 0)
                return true;
        }
        return false;
    }

    private function getBadge(Collection $badges, $badgeId) {
        foreach ($badges as $badge) {
            if($badge->badgeID == $badgeId)
                return $badge;
        }
        return null;
    }

    public function getGamificationNextStepViewModel($unlockedBadges) {
        /**
         * if the project does not have an active questionnaire that has not been answered by this user, then prompt the user to wait for
         * a questionnaire to be posted
         *
         * else
         */
        if(!$this->crowdSourcingProjectManager->getActiveQuestionnaireForProject()) {
            $title = 'This project does not have an active Questionnaire yet.<br>Wait for a questionnaire to be posted, and contribute with your answers!';
            $imgFileName = 'contributor.png';
            return new GamificationNextStep(
                $this->crowdSourcingProjectManager->getDefaultCrowdsourcingProject(),
                $title,
                $imgFileName,
                false,
                null,
                false);
        } else {
            return $this->getGamificationNextStepViewModelForBadges($unlockedBadges);
        }
    }

    private function getGamificationNextStepViewModelForBadges(Collection $unlockedBadges) {

        $badgeToShow = null;

        if($this->userHasAchievedBadge($unlockedBadges, GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID)) {
            if($this->userHasAchievedBadge($unlockedBadges, GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID)) {
                $badgeToShow = $this->getBadge($unlockedBadges,GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID);
            } else {
                $badgeToShow = $this->getBadge($unlockedBadges, GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID);
            }
        } else {
            $badgeToShow = $this->getBadge($unlockedBadges, GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID);
        }

        $questionnaire = $this->crowdSourcingProjectManager->getActiveQuestionnaireForProject();
        $project = $this->crowdSourcingProjectManager->getDefaultCrowdsourcingProject();
        return new GamificationNextStep(
            $project,
            $badgeToShow->getNextStepMessage(),
            $badgeToShow->imageFileName,
            true,
            new QuestionnaireSocialShareButtons($project, $questionnaire, Auth::id()),
            $this->questionnaireAnswerManager->userHasAlreadyAnsweredTheActiveQuestionnaire(Auth::id()));
    }

    public function getContributorBadge($userId) {
        $allResponses = $this->questionnaireRepository->getAllResponsesGivenByUser($userId)->count();
        return new ContributorBadge($allResponses);
    }

    public function getInfluencerBadge($userId, $questionnaire) {
        $numberOfActionsPerformedForQuestionnaire = null;
        $percentageForActiveQuestionnaire = null;
        $totalQuestionnaireReferrals = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUser($userId)->count();
        $numberOfActionsPerformedForQuestionnaire = 0;
        if($questionnaire) {
            $numberOfActionsPerformedForQuestionnaire = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUserForQuestionnaire($questionnaire->id, $userId)->count();
            $percentageForActiveQuestionnaire =  ($numberOfActionsPerformedForQuestionnaire / $questionnaire->goal) * 100;
        }
        return new InfluencerBadge($totalQuestionnaireReferrals, $numberOfActionsPerformedForQuestionnaire, $percentageForActiveQuestionnaire);
    }

    public function getCommunicatorBadge($userId) {
        return new CommunicatorBadge($this->questionnaireShareManager->getQuestionnairesSharedByUser($userId)->count(), $userId);
    }

    public function notifyUserForCommunicatorBadge($questionnaire, $user) {
        $communicatorBadge = $this->getCommunicatorBadge($user->id);
        try {
            $user->notify(new QuestionnaireShared($questionnaire, $communicatorBadge, $this->getBadgeViewModel($communicatorBadge)));
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}