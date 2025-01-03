<?php

namespace App\ViewModels\User;

use App\Models\User\User;
use App\ViewModels\Gamification\GamificationBadgesWithLevels;
use Illuminate\Support\Collection;

class UserDashboardViewModel {
    public Collection $questionnaires;
    public Collection $projectsWithActiveProblems;
    public GamificationBadgesWithLevels $platformWideGamificationBadgesVM;
    public User $user;

    public function __construct(Collection $questionnaires,
        Collection $projectsWithActiveProblems,
        GamificationBadgesWithLevels $platformWideGamificationBadgesVM,
        User $user) {
        $this->questionnaires = $questionnaires;
        $this->projectsWithActiveProblems = $projectsWithActiveProblems;
        $this->platformWideGamificationBadgesVM = $platformWideGamificationBadgesVM;
        $this->user = $user;
    }
}
