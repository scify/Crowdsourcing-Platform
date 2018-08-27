<?php

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class GamificationBadgesWithLevels {

    public $badgesWithLevelsList;
    public $totalPoints;

    public function __construct(Collection$badgesWithLevelsList, int $totalPoints) {
        $this->badgesWithLevelsList = $badgesWithLevelsList;
        $this->totalPoints = $totalPoints;
    }

}