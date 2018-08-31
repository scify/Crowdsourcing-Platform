<?php

namespace App\BusinessLogicLayer\gamification;


class CommunicatorBadge extends GamificationBadge {

    public function __construct(int $questionnairesSharedByUser, $userId) {
        $this->badgeID = GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID;
        $this->color = '#4CAF50';
        $numberOfActionsPerformed = $questionnairesSharedByUser;
        parent::__construct("Communicator",
            "communicator.png",
            "Gain this badge, by inviting more people to participate. Share to Facebook and Twitter!",
            $numberOfActionsPerformed);
    }

    protected function getBadgeMessageForLevel() {
        return 'You have shared ' . $this->numberOfActionsPerformed . ' questionnaires';
    }

    public function getEmailBody() {
        // TODO: Implement getEmailBody() method.
    }

    public function getNextStepMessage() {
        return 'Invite your friends to answer and get the "Communicator" badge!';
    }
}