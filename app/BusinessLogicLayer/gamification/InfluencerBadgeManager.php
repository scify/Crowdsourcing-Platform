<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\UserQuestionnaireShareManager;

class InfluencerBadgeManager extends GamificationBadge {

    const CONTRIBUTOR_LOW_LEVEL = 0;
    const CONTRIBUTOR_MID_LEVEL = 5;
    const CONTRIBUTOR_HIGH_LEVEL = 10;
    private $questionnaireShareManager;

    public function __construct(UserQuestionnaireShareManager $questionnaireShareManager) {
        $this->questionnaireShareManager = $questionnaireShareManager;
    }

    public function getBadgeMessageForLevel(int $level) {
        switch ($level) {
            case $level == self::CONTRIBUTOR_LOW_LEVEL:
                return "You are in lower level";
            case $level <= self::CONTRIBUTOR_MID_LEVEL:
                return "You are in mid level";
            case $level <= self::CONTRIBUTOR_HIGH_LEVEL:
                return "You are in high level";
            case $level > self::CONTRIBUTOR_HIGH_LEVEL:
                return "You are in highest level";
            default:
                throw new \Exception("Unsupported gamification level: " . $level);
        }
    }

    public function getNumberOfActionsPerformed(int $userId) {
        return $this->questionnaireShareManager->getQuestionnairesSharedByUser($userId)->count();
    }

    public function getBadgeName() {
        return "Influencer";
    }

    public function getBadgeImageName() {
        return "influencer.png";
    }
}