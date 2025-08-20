<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Gamification;

class ContributorBadge extends GamificationBadge {
    public function __construct(int $numberOfActionsPerformed, bool $userHasAchievedBadgePlatformWide) {
        $this->badgeID = GamificationBadgeIdsEnum::CONTRIBUTOR_BADGE_ID;
        $this->color = '#3F51B5';
        parent::__construct(
            __('badges_messages.contributor_title'),
            'contributor.png',
            __('badges_messages.contributor_badge_points_explanation'),
            $numberOfActionsPerformed,
            $userHasAchievedBadgePlatformWide,
            5,
            __('badges_messages.contributor_bade_progress', ['count' => $numberOfActionsPerformed]),
            50
        );
    }

    protected function getBadgeMessageForLevel(): string {
        return __('badges_messages.contributor_badge_points_explanation', ['points' => $this->pointsPerAction]);
    }

    public function getEmailBody(): string {
        if ($this->level == 1) {
            return __('email_messages.unlocked_new_badge');
        }

        return __('badges_messages.you_are_a_contributor', ['level' => sprintf('<b> %s </b>', $this->level)]);
    }

    public function getNextStepMessage(): string {
        if ($this->userHasAchievedBadgePlatformWide) {
            return __('badges_messages.become_a_contributor', ['level' => '<b>' . ($this->calculateLevel() + 1) . '</b>']);
        }

        return __('badges_messages.gain_contributor_badge');
    }
}
