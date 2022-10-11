<?php

namespace App\Models\ViewModels;

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
