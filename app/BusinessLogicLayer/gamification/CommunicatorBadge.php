<?php

namespace App\BusinessLogicLayer\gamification;


class CommunicatorBadge extends GamificationBadge {

    public function __construct(int $questionnairesSharedByUser, $userHasAchievedBadgePlatformWide) {
        $this->badgeID = GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID;
        $this->color = '#4CAF50';
        $numberOfActionsPerformed = $questionnairesSharedByUser;
        parent::__construct("Communicator",
            "communicator.png",
            "Gain this badge, by inviting more people to participate. Share to Facebook and Twitter!",
            $numberOfActionsPerformed, $userHasAchievedBadgePlatformWide);
    }

    protected function getBadgeMessageForLevel() {
        $message = 'Other users have clicked on your shared questionnaires ' . $this->numberOfActionsPerformed . ' time';
        if($this->numberOfActionsPerformed > 1)
            $message .= 's';
        return $message;
    }

    public function getEmailBody() {
        if($this->level == 1)
            return 'You have also unlocked a new badge:';
        return 'You are a Level <b>' . $this->level . '</b> Communicator! Keep Going!';
    }

    public function getNextStepMessage() {
        if($this->userHasAchievedBadgePlatformWide)
            return 'Invite more friends to answer<br>and become a level <b>' . ($this->calculateLevel() + 1) . '</b> Communicator!';
        return 'Invite your friends to answer, and get the "Communicator" badge!';
    }
}
