<?php

namespace App\ViewModels;

use App\BusinessLogicLayer\gamification\GamificationBadge;

class GamificationBadgeVM {
    public $badgeImageName;
    public $badgeName;
    public $level;
    public $badgeMessage;
    public $statusMessage;
    public $color;

    public function __construct(GamificationBadge $badge) {
        $this->badgeName = $badge->name;
        $this->level = $badge->level;
        $this->badgeMessage = $badge->messageForLevel;
        $this->badgeImageName = $badge->imageFileName;
        $this->statusMessage = $badge->statusMessage;
        $this->color = $badge->color;
    }
}
