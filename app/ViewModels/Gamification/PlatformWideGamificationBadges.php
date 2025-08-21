<?php

declare(strict_types=1);

namespace App\ViewModels\Gamification;

class PlatformWideGamificationBadges {
    /**
     * @var \App\ViewModels\Gamification\GamificationBadgeVM
     */
    public $contributorBadge;

    /**
     * @var \App\ViewModels\Gamification\GamificationBadgeVM
     */
    public $communicatorBadge;

    /**
     * @var \App\ViewModels\Gamification\GamificationBadgeVM
     */
    public $influencerBadge;

    public function __construct(GamificationBadgeVM $contributorBadge, GamificationBadgeVM $communicatorBadge, GamificationBadgeVM $influencerBadge) {
        $this->contributorBadge = $contributorBadge;
        $this->communicatorBadge = $communicatorBadge;
        $this->influencerBadge = $influencerBadge;
    }
}
