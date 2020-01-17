<?php

namespace App\BusinessLogicLayer\gamification;


class AllBadgesCompletedBadge extends GamificationBadge {

    public function __construct() {
        $this->badgeID = GamificationBadgeIdsEnum::ALL_BADGES_COMPLETED_BADGE_ID;
        $this->color = '#f44336';

        parent::__construct("All badges completed",
            "all_badges_completed.png",
            "Congratulations! You received all available badges!",
            0);
    }

    public function getBadgeMessageForLevel() {
        return 'You made a huge impact in this questionnaire!';
    }

    public function getEmailBody() {
        return "";
    }

    public function getNextStepMessage() {
        return "Congratulations! You have received all available badges for this questionnaire! You are an all-star contributor!";
    }
}
