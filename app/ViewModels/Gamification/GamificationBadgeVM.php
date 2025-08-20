<?php

declare(strict_types=1);

namespace App\ViewModels\Gamification;

use App\BusinessLogicLayer\Gamification\GamificationBadge;

class GamificationBadgeVM {
    public string $badgeImageName;

    public string $badgeName;

    public int $level;

    public string $badgeMessage;

    public string $statusMessage;

    public string $color;

    public string $messageForLevel;

    public GamificationBadge $badge;

    public function __construct(GamificationBadge $badge) {
        $this->badgeName = $badge->name;
        $this->level = $badge->level;
        $this->badgeMessage = $badge->messageForLevel;
        $this->badgeImageName = $badge->imageFileName;
        $this->statusMessage = $badge->statusMessage;
        $this->color = $badge->color;
        $this->messageForLevel = $badge->messageForLevel;
        $this->badge = $badge;
    }

    public function computeLevelProgressPercentage(): int {
        // return the percentage of the level progress
        // if greater than 100, return 100
        // if equal to 0, return 1 (as a default minimum)

        $percentage = ($this->level / $this->badge->finalLevel) * 100;

        return $percentage > 100 ? 100 : ($percentage == 0 ? 1 : $percentage);
    }
}
