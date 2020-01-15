<?php

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class UserDashboardViewModel
{
    public $projects;
    public $platformWideGamificationBadgesVM;

    public function __construct(Collection $projects,
                                GamificationBadgesWithLevels $platformWideGamificationBadgesVM) {
        $this->projects = $projects;
        $this->platformWideGamificationBadgesVM = $platformWideGamificationBadgesVM;
    }

}
