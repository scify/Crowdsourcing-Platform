<?php

namespace App\BusinessLogicLayer\gamification;

class CommunicatorBadge extends GamificationBadge {
    public function __construct(int $questionnairesSharedByUser, $userHasAchievedBadgePlatformWide) {
        $this->badgeID = GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID;
        $this->color = '#4CAF50';
        $numberOfActionsPerformed = $questionnairesSharedByUser;

        parent::__construct(__('badges_messages.communicator_title'),
            'communicator.png',
            __('badges_messages.gain_badge_by_inviting'),
            $numberOfActionsPerformed, $userHasAchievedBadgePlatformWide, 10,
            __('badges_messages.communicator_bade_progress', ['count' => $numberOfActionsPerformed]),
            60);
    }

    protected function getBadgeMessageForLevel(): string {
        return __('badges_messages.communicator_badge_points_explanation', ['points' => $this->pointsPerAction]);
    }

    public function getEmailBody(): string {
        if ($this->level == 1) {
            return __('email_messages.unlocked_new_badge');
        }

        return __('badges_messages.you_are_a_communicator', ['level' => "<b> $this->level </b>"]);
    }

    public function getNextStepMessage(): string {
        if ($this->userHasAchievedBadgePlatformWide) {
            return __('badges_messages.become_a_communicator', ['level' => '<b> ' . ($this->calculateLevel() + 1) . '</b>']);
        }

        return __('badges_messages.gain_communicator_badge');
    }
}
