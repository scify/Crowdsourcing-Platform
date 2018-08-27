<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\UserQuestionnaireShareManager;

class InfluencerBadgeManager extends GamificationBadge {

    private $questionnaireShareManager;

    public function __construct(UserQuestionnaireShareManager $questionnaireShareManager, $userId) {
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
        $this->numberOfActionsPerformed = $this->questionnaireShareManager->getQuestionnairesSharedByUser($userId)->count();
    }

    public function getBadgeMessageForLevel(int $level) {
        return 'You have shared ' . $this->numberOfActionsPerformed . ' questionnaires';
    }

    public function getNumberOfActionsPerformed(int $userId) {
        return $this->numberOfActionsPerformed;
    }

    public function getBadgeName() {
        return "Influencer";
    }

    public function getBadgeImageName() {
        return "influencer.png";
    }
}