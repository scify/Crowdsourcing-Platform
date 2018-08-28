<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Models\ViewModels\GamificationBadgeLevel;
use App\Models\ViewModels\GamificationBadgesWithLevels;
use App\Models\ViewModels\GamificationNextStep;
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
        $infuencerBadge = new InfluencerBadge($this->questionnaireShareManager, $userId);
        $persuaderBadge = new PersuaderBadge($this->questionnaireResponseReferralManager, $userId);
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
        $badgeName = $gamificationBadge->name;
        $badgeImageName = $gamificationBadge->imageFileName;
        $level = $gamificationBadge->level;
        $badgeMessage = $gamificationBadge->messageForLevel;
        $statusMessage = $gamificationBadge->statusMessage;
        return new GamificationBadgeLevel($badgeName, $level, $badgeMessage, $badgeImageName, $statusMessage);
    }

    public function contributorBadgeExistsInBadges(Collection $badges) {
        return $this->badgeExistsInBadges($badges, GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID);
    }

    public function influencerBadgeExistsInBadges(Collection $badges) {
        return $this->badgeExistsInBadges($badges, GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID);
    }

    public function persuaderBadgeExistsInBadges(Collection $badges) {
        return $this->badgeExistsInBadges($badges, GamificationBadgeIdsEnum::PERSUADER_BADGE_ID);
    }

    public function badgeExistsInBadges(Collection $badges, $badgeId) {
        foreach ($badges as $badge) {
            if($badge->badgeID == $badgeId && $badge->level > 0)
                return true;
        }
        return false;
    }

    public function getGamificationNextStepViewModel($unlockedBadges) {
        /**
         * if the project does not have an active questionnaire, then prompt the user to wait for
         * a questionnaire to be posted
         *
         * else
         */
        if(!$this->crowdSourcingProjectManager->projectHasActiveQuestionnaire(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID)) {
            $title = 'This project does not have an active Questionnaire yet.';
            $subtitle = 'Wait for a questionnaire to be posted and contribute your answer!';
            $imgFileName = 'contributor.png';
            return new GamificationNextStep($title, $subtitle, $imgFileName);
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
            if($this->influencerBadgeExistsInBadges($unlockedBadges)) {
                if($this->persuaderBadgeExistsInBadges($unlockedBadges)) {
                    $title = 'Thank you for sharing the Questionnaire!';
                    $subtitle = 'Keep inviting people to contribute by sharing the Questionnaire to Facebook to score more points!';
                    $imgFileName = 'persuader.png';
                } else {
                    $title = 'We are waiting for response!';
                    $subtitle = 'Once we receive a response, you will get the "Persuader" badge.';
                    $imgFileName = 'persuader.png';
                }
            } else {
                $title = 'Thank you for your contribution to the Questionnaire!';
                $subtitle = 'Invite users to answer by sharing the Questionnaire to Facebook to get the "Influencer" badge.';
                $imgFileName = 'influencer.png';
            }
        } else {
            $title = 'This project has an active Questionnaire!';
            $subtitle = 'Contribute with your answer and get the "Contributor" badge.';
            $imgFileName = 'contributor.png';
        }

        return new GamificationNextStep($title, $subtitle, $imgFileName);
    }
}