<?php

namespace App\ViewModels;

use App\Models\User;
use Illuminate\Support\Collection;

class UserDashboardViewModel {
    public Collection $questionnaires;
    public GamificationBadgesWithLevels $platformWideGamificationBadgesVM;
    public User $user;

    public function __construct(Collection $questionnaires,
        GamificationBadgesWithLevels $platformWideGamificationBadgesVM,
        User $user) {
        $this->questionnaires = $questionnaires;
        $this->platformWideGamificationBadgesVM = $platformWideGamificationBadgesVM;
        $this->user = $user;
    }
}
