<?php

namespace App\ViewModels\Gamification;

class PlatformWideGamificationBadges {
    public $contributorBadge;
    public $communicatorBadge;
    public $influencerBadge;

    public function __construct(GamificationBadgeVM $contributorBadge, GamificationBadgeVM $communicatorBadge, GamificationBadgeVM $influencerBadge) {
        $this->contributorBadge = $contributorBadge;
        $this->communicatorBadge = $communicatorBadge;
        $this->influencerBadge = $influencerBadge;
    }
}
