<?php

namespace App\ViewModels;

use App\BusinessLogicLayer\gamification\GamificationBadge;

class GamificationBadgeVM {
    public string $badgeImageName;
    public string $badgeName;
    public int $level;
    public string $badgeMessage;
    public string $statusMessage;
    public string $color;
    public string $messageForLevel;

    public function __construct(GamificationBadge $badge) {
        $this->badgeName = $badge->name;
        $this->level = $badge->level;
        $this->badgeMessage = $badge->messageForLevel;
        $this->badgeImageName = $badge->imageFileName;
        $this->statusMessage = $badge->statusMessage;
        $this->color = $badge->color;
        $this->messageForLevel = $badge->messageForLevel;
    }
}
