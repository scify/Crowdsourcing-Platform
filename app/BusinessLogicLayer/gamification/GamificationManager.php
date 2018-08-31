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
        $contributorBadge = new ContributorBadge($this->questionnaireRepository, $userId);
        $infuencerBadge = new CommunicatorBadge($this->questionnaireShareManager, $userId);
        $activeQuestionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID);
        $persuaderBadge = new InfluencerBadge($this->questionnaireResponseReferralManager, $userId, $activeQuestionnaire);
        return new Collection([
            $contributorBadge,
            $infuencerBadge,
            $persuaderBadge
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

    public function contributorBadgeExistsInBadges(Collection $badges) {
        return $this->badgeExistsInBadges($badges, GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID);
    }

    public function communicatorBadgeExistsInBadges(Collection $badges) {
        return $this->badgeExistsInBadges($badges, GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID);
    }

    public function influencerBadgeExistsInBadges(Collection $badges) {
        return $this->badgeExistsInBadges($badges, GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID);
    }

    public function badgeExistsInBadges(Collection $badges, $badgeId) {
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
        /**
         * if the user has the contributor badge
         *      if the user has the influencer badge
         *          if the user has the persuader badge
         *              prompt the user to share again to increase their impact
         *          else
         *              prompt the user to share the questionnaire to get the persuader badge
         *      else
         *          prompt the user to share the questionnaire to get the influencer badge
         *  else
         *      prompt the user to answer to the questionnaire
         *
         */
        $title = null;
        $subtitle = null;
        $imgFileName = null;
        if($this->contributorBadgeExistsInBadges($unlockedBadges)) {
            if($this->communicatorBadgeExistsInBadges($unlockedBadges)) {
                if($this->influencerBadgeExistsInBadges($unlockedBadges)) {
                    $influencerBadge = $this->getBadge($unlockedBadges, GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID);
                    // if less than 2%
                    if($influencerBadge->percentageForActiveQuestionnaire < 2)
                        $title = 'Good job! ' . $influencerBadge->numberOfActionsPerformedForQuestionnaire . ' have responded to your call so far.<br>Write a compelling message and invite more friends!';
                    else
                        $title = 'Wow, you are a true influencer!<br>' . $influencerBadge->numberOfActionsPerformedForQuestionnaire . ' people have responded to your call so far. Write a compelling message and invite more friends!';
                    $imgFileName = 'influencer.png';
                } else {
                    $title = 'Zero people have responded to you call so far.<br>Write a compelling message and invite more friends!';
                    $imgFileName = 'influencer.png';
                }
            } else {
                $title = 'Invite your friends to answer and get the "Communicator" badge!';
                $imgFileName = 'communicator.png';
            }
        } else {
            $title = 'Tell us what you think<br>and get the "Contributor" badge!';
            $imgFileName = 'contributor.png';
        }

        $questionnaire = $this->questionnaireRepository->getActiveQuestionnaireForProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID);
        $project = $this->crowdSourcingProjectManager->getCrowdSourcingProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID);
        return new GamificationNextStep(
            $this->crowdSourcingProjectManager->getCrowdSourcingProject(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID),
            $title,
            $imgFileName,
            true,
            new QuestionnaireSocialShareButtons($project, $questionnaire, \Auth::id()),
            $this->crowdSourcingProjectManager->userHasAlreadyAnsweredTheActiveQuestionnaire(\Auth::id())
            );
    }

    public function getContributorBadgeForUser($userId) {
        return new ContributorBadge($this->questionnaireRepository, $userId);
    }

    public function getInfluencerBadgeForUser($userId, $questionnaire) {
        return new InfluencerBadge($this->questionnaireResponseReferralManager, $userId, $questionnaire);
    }

    public function getCommunicatorBadgeForUser($userId) {
        return new CommunicatorBadge($this->questionnaireShareManager, $userId);
    }

    public function notifyUserForCommunicatorBadge($questionnaire, $user) {
        $communicatorBadge = $this->getCommunicatorBadgeForUser($user->id);
        $user->notify(new ReferredQuestionnaireAnswered($questionnaire, $communicatorBadge, $this->getBadgeViewModel($communicatorBadge)));
    }
}