<?php

declare(strict_types=1);

namespace App\ViewModels\Gamification;

class PlatformWideGamificationBadges {
    /**
     * @var GamificationBadgeVM
     */
    public $contributorBadge;

    /**
     * @var GamificationBadgeVM
     */
    public $communicatorBadge;

    /**
     * @var GamificationBadgeVM
     */
    public $influencerBadge;

    public function __construct(GamificationBadgeVM $contributorBadge, GamificationBadgeVM $communicatorBadge, GamificationBadgeVM $influencerBadge) {
        $this->contributorBadge = $contributorBadge;
        $this->communicatorBadge = $communicatorBadge;
        $this->influencerBadge = $influencerBadge;
    }
}
