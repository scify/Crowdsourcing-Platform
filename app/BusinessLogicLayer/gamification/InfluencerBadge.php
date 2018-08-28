<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\UserQuestionnaireShareManager;

class InfluencerBadge extends GamificationBadge {

    private $questionnaireShareManager;

    public function __construct(UserQuestionnaireShareManager $questionnaireShareManager, $userId) {
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
        $numberOfActionsPerformed = $this->questionnaireShareManager->getQuestionnairesSharedByUser($userId)->count();
        parent::__construct("Influencer", "influencer.png", $numberOfActionsPerformed, $userId);
    }

    protected function getBadgeMessageForLevel() {
        return 'You have shared ' . $this->numberOfActionsPerformed . ' questionnaires';
    }
}