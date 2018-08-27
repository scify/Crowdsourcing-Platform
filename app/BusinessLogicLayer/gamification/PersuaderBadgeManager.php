<?php

namespace App\BusinessLogicLayer\gamification;


use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;

class PersuaderBadgeManager extends GamificationBadge {

    const PERSUADER_LOW_LEVEL = 0;
    const PERSUADER_MID_LEVEL = 5;
    const PERSUADER_HIGH_LEVEL = 10;
    private $questionnaireResponseReferralManager;

    public function __construct(QuestionnaireResponseReferralManager $questionnaireResponseReferralManager) {
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->pointsPerAction = 5;
    }

    public function getBadgeMessageForLevel(int $level) {
        switch ($level) {
            case $level == self::PERSUADER_LOW_LEVEL:
                return "You are in lower level";
            case $level <= self::PERSUADER_MID_LEVEL:
                return "You are in mid level";
            case $level <= self::PERSUADER_HIGH_LEVEL:
                return "You are in high level";
            case $level > self::PERSUADER_HIGH_LEVEL:
                return "You are in highest level";
            default:
                throw new \Exception("Unsupported gamification level: " . $level);
        }
    }

    public function getNumberOfActionsPerformed(int $userId) {
        return $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUser($userId)->count();
    }

    public function getBadgeName() {
        return "Persuader";
    }

    public function getBadgeImageName() {
        return "persuader.png";
    }
}