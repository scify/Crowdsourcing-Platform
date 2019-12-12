<?php

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class DashboardInfo
{
    public $projects;
    public $badgesVM;
    public $gamificationNextStepVM;

    public function __construct(Collection $projects,
                                GamificationBadgesWithLevels $badgesVM,
                                $gamificationNextStepViewModel) {
        $this->projects = $projects;
        $this->badgesVM = $badgesVM;
        $this->gamificationNextStepVM = $gamificationNextStepViewModel;
    }

}
