<?php

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class UserDashboardViewModel
{
    public $questionnaires;
    public $platformWideGamificationBadgesVM;

    public function __construct(Collection $questionnaires,
                                GamificationBadgesWithLevels $platformWideGamificationBadgesVM) {
        $this->questionnaires = $questionnaires;
        $this->platformWideGamificationBadgesVM = $platformWideGamificationBadgesVM;
    }

}
