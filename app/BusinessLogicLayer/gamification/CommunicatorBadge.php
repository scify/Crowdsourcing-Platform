<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\UserQuestionnaireShareManager;

class CommunicatorBadge extends GamificationBadge {

    private $questionnaireShareManager;

    public function __construct(UserQuestionnaireShareManager $questionnaireShareManager, $userId) {
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->badgeID = GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID;
        $numberOfActionsPerformed = $this->questionnaireShareManager->getQuestionnairesSharedByUser($userId)->count();
        parent::__construct("Communicator",
            "communicator.png",
            "Gain this badge, by inviting more people to participate. Share to Facebook and Twitter!",
            $numberOfActionsPerformed, $userId);
    }

    protected function getBadgeMessageForLevel() {
        return 'You have shared ' . $this->numberOfActionsPerformed . ' questionnaires';
    }
}