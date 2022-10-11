<?php

namespace App\BusinessLogicLayer\gamification;

class AllBadgesCompletedBadge extends GamificationBadge {
    public function __construct() {
        $this->badgeID = GamificationBadgeIdsEnum::ALL_BADGES_COMPLETED_BADGE_ID;
        $this->color = '#f44336';

        parent::__construct(__('badges_messages.badges_completed'),
            'all_badges_completed.png',
            __('badges_messages.received_all_badges'),
            0, true);
    }

    public function getBadgeMessageForLevel() {
        return __('badges_messages.huge_impact');
    }

    public function getEmailBody() {
        return '';
    }

    public function getNextStepMessage() {
        return __('badges_messages.all_star_crowdsourcer');
    }
}
