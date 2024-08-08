<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;

class GamificationBadgesWithLevels {
    public $badgesWithLevelsList;
    public $totalPoints;
    public $numOfBadges;

    public function __construct(Collection $badgesWithLevelsList, int $totalPoints) {
        $this->badgesWithLevelsList = $badgesWithLevelsList;
        $this->totalPoints = $totalPoints;
        $this->numOfBadges = $this->getNumOfBadges();
    }

    private function getNumOfBadges() {
        $i = 0;
        foreach ($this->badgesWithLevelsList as $item) {
            if ($item->level) {
                $i++;
            }
        }

        return $i;
    }
}
