<?php

namespace App\BusinessLogicLayer\gamification;


use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;

class PersuaderBadgeManager extends GamificationBadge {

    private $questionnaireResponseReferralManager;

    public function __construct(QuestionnaireResponseReferralManager $questionnaireResponseReferralManager, int $userId) {
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->pointsPerAction = 5;
        $this->badgeID = GamificationBadgeIdsEnum::PERSUADER_BADGE_ID;
        $this->numberOfActionsPerformed = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUser($userId)->count();
    }

    public function getBadgeMessageForLevel(int $level) {
        return 'You have invited ' . $this->numberOfActionsPerformed . ' people to answer';
    }

    public function getNumberOfActionsPerformed(int $userId) {
        return $this->numberOfActionsPerformed;
    }

    public function getBadgeName() {
        return "Persuader";
    }

    public function getBadgeImageName() {
        return "persuader.png";
    }
}