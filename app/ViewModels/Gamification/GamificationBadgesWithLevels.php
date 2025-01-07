<?php

namespace App\ViewModels\Gamification;

use Illuminate\Support\Collection;

class GamificationBadgesWithLevels {
    public int $numOfBadges;

    public function __construct(public Collection $badgesWithLevelsList) {
        $this->numOfBadges = $this->getNumOfBadges();
    }

    private function getNumOfBadges(): int {
        $i = 0;
        foreach ($this->badgesWithLevelsList as $item) {
            if ($item->level) {
                $i++;
            }
        }

        return $i;
    }

    public function getTotalPoints(): int {
        $totalPoints = 0;
        foreach ($this->badgesWithLevelsList as $badge) {
            $totalPoints += $badge->level;
        }

        return $totalPoints;
    }

    public function getMaxTotalPoints(): int {
        return 100;
    }

    public function computeTotalPointsProgressPercentage(): int {
        // return the percentage of the points progress
        // if greater than 100, return 100
        // if equal to 0, return 1 (as a default minimum)

        $percentage = ($this->getTotalPoints() / $this->getMaxTotalPoints()) * 100;

        return $percentage > 100 ? 100 : ($percentage == 0 ? 1 : $percentage);
    }
}
