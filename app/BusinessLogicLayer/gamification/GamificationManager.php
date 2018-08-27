<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Models\ViewModels\GamificationBadgeLevel;
use App\Models\ViewModels\GamificationBadgesWithLevels;
use App\Repository\QuestionnaireRepository;
use Illuminate\Support\Collection;

class GamificationManager {

    private $questionnaireRepository;
    private $questionnaireShareManager;
    private $questionnaireResponseReferralManager;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                QuestionnaireResponseReferralManager $questionnaireResponseReferralManager) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
    }

    public function getGamificationLevelsViewModelForUser(int $userId) {
        $contributorBadge = new ContributorBadgeManager($this->questionnaireRepository);
        $infuencerBadge = new InfluencerBadgeManager($this->questionnaireShareManager);
        $persuaderBadge = new PersuaderBadgeManager($this->questionnaireResponseReferralManager);
        $badgesWithLevelsCollection = new Collection([
            $this->getBadgeWithLevelViewModelForUser($contributorBadge, $userId),
            $this->getBadgeWithLevelViewModelForUser($infuencerBadge, $userId),
            $this->getBadgeWithLevelViewModelForUser($persuaderBadge, $userId)
        ]);
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
}