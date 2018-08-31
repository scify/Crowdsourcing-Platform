<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Models\ViewModels\GamificationBadgesWithLevels;
use App\Models\ViewModels\GamificationNextStep;
use App\Models\ViewModels\QuestionnaireSocialShareButtons;
use App\Notifications\ReferredQuestionnaireAnswered;
use App\Repository\QuestionnaireRepository;
use Illuminate\Support\Collection;

class GamificationManager {

    private $questionnaireRepository;
    private $questionnaireShareManager;
    private $questionnaireResponseReferralManager;
    private $crowdSourcingProjectManager;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                CrowdSourcingProjectManager $crowdSourcingProjectManager,
                                QuestionnaireResponseReferralManager $questionnaireResponseReferralManager) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function getGamificationBadgesForUser(int $userId) {
        return new Collection([
            $this->getContributorBadge($userId),
            $this->getCommunicatorBadge($userId),
            $this->getInfluencerBadge($userId)
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
         * if the project does not have an active questionnaire, then prompt the user to wait for
         * a questionnaire to be posted
         *
         * else
         */
        if(!$this->crowdSourcingProjectManager->projectHasActiveQuestionnaire(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID)) {
            $title = 'This project does not have an active Questionnaire yet.<br>Wait for a questionnaire to be posted and contribute your answer!';
            $imgFileName = 'contributor.png';
            return new GamificationNextStep(
                $this->crowdSourcingProjectManager->getCrowdSourcingProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID),
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

        $questionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID);
        $project = $this->crowdSourcingProjectManager->getCrowdSourcingProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID);
        return new GamificationNextStep(
            $this->crowdSourcingProjectManager->getCrowdSourcingProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID),
            $badgeToShow->getNextStepMessage(),
            $badgeToShow->imageFileName,
            true,
            new QuestionnaireSocialShareButtons($project, $questionnaire, \Auth::id()), $this->crowdSourcingProjectManager->userHasAlreadyAnsweredTheActiveQuestionnaire(\Auth::id()));
    }

    public function getContributorBadge($userId) {
        $allResponses = $this->questionnaireRepository->getAllResponsesGivenByUser($userId)->count();
        return new ContributorBadge($allResponses);
    }

    public function getInfluencerBadge($userId) {
        $numberOfActionsPerformedForQuestionnaire = null;
        $percentageForActiveQuestionnaire = null;
        $totalQuestionnaireReferrals = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUser($userId)->count();
        $activeQuestionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID);
        if($activeQuestionnaire) {
            $numberOfActionsPerformedForQuestionnaire = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUserForQuestionnaire($activeQuestionnaire->id, $userId)->count();
            $percentageForActiveQuestionnaire =  ($numberOfActionsPerformedForQuestionnaire / $activeQuestionnaire->goal) * 100;
        }
        return new InfluencerBadge($totalQuestionnaireReferrals, $numberOfActionsPerformedForQuestionnaire, $percentageForActiveQuestionnaire);
    }

    public function getCommunicatorBadge($userId) {
        return new CommunicatorBadge($this->questionnaireShareManager->getQuestionnairesSharedByUser($userId)->count(), $userId);
    }

    public function notifyUserForCommunicatorBadge($questionnaire, $user) {
        $communicatorBadge = $this->getCommunicatorBadge($user->id);
        $user->notify(new ReferredQuestionnaireAnswered($questionnaire, $communicatorBadge, $this->getBadgeViewModel($communicatorBadge)));
    }
}