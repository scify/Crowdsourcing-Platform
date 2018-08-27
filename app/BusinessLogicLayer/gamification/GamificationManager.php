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
        $contributorBadge = new ContributorBadgeManager($this->questionnaireRepository, $userId);
        $infuencerBadge = new InfluencerBadgeManager($this->questionnaireShareManager, $userId);
        $persuaderBadge = new PersuaderBadgeManager($this->questionnaireResponseReferralManager, $userId);
        return new Collection([
            $contributorBadge,
            $infuencerBadge,
            $persuaderBadge
        ]);
    }

    public function getGamificationLevelsViewModelForUser(int $userId, Collection $badges) {
        $badgesWithLevelsCollection = new Collection();
        foreach ($badges as $badge) {
            $badgesWithLevelsCollection->push($this->getBadgeWithLevelViewModelForUser($badge, $userId));
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

    public function getBadgeWithLevelViewModelForUser(GamificationBadge $gamificationBadge, int $userId) {
        $badgeName = $gamificationBadge->getBadgeName();
        $badgeImageName = $gamificationBadge->getBadgeImageName();
        $level = $gamificationBadge->getLevel($userId);
        $badgeMessage = $gamificationBadge->getBadgeMessageForLevel($level);
        return new GamificationBadgeLevel($badgeName, $level, $badgeMessage, $badgeImageName);
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
            if($badge->badgeId == $badgeId)
                return true;
        }
        return false;
    }

    public function getGamificationNextStepViewModel($userId, $unlockedBadges) {
        if(!$this->crowdSourcingProjectManager->projectHasActiveQuestionnaire(CrowdSourcingProjectManager::DEFAULT_PROJECT_ID)) {

        }
        $title = 'This project does not have an active Questionnaire yet.';
        $subtitle = 'Wait for a questionnaire to be posted and contribute your answer!';
        $imgFileName = 'contributor.png';

        return new GamificationNextStep($title, $subtitle, $imgFileName);
    }
}