<?php

declare(strict_types=1);

namespace App\ViewModels\User;

use App\Models\User\User;
use App\ViewModels\Gamification\GamificationBadgesWithLevels;
use Illuminate\Support\Collection;

class UserDashboardViewModel {
    public function __construct(public Collection $questionnaires, public Collection $projectsWithActiveProblems, public GamificationBadgesWithLevels $platformWideGamificationBadgesVM, public User $user) {}
}
