<?php


namespace App\BusinessLogicLayer;


use Illuminate\Support\Collection;

class GamificationPointsCalculator {

    public function calculateTotalGamificationPoints(Collection $badgesWithLevelsCollection) {
        $totalPoints = 0;
        foreach ($badgesWithLevelsCollection as $badge) {
            $totalPoints += $badge->level;
        }
        return $totalPoints;
    }

}
