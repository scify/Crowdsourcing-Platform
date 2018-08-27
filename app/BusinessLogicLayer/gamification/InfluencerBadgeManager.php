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
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
    }

    public function getBadgeMessageForLevel(int $level) {
        return 'You have shared ' . $this->numberOfActionsPerformed . ' questionnaires';
    }

    public function getNumberOfActionsPerformed(int $userId) {
        if($this->numberOfActionsPerformed == -1)
            $this->numberOfActionsPerformed = $this->questionnaireShareManager->getQuestionnairesSharedByUser($userId)->count();
        return $this->numberOfActionsPerformed;
    }

    public function getBadgeName() {
        return "Influencer";
    }

    public function getBadgeImageName() {
        return "influencer.png";
    }
}