<?php

namespace App\ViewComposers;

use App\BusinessLogicLayer\UserManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MenuComposer {
    protected $userManager;

    public function __construct(UserManager $userManager) {
        $this->userManager = $userManager;
    }

    public function compose(View $view) {
        $view->with(['userHasContributedToAProject' => $this->userManager->userHasContributedToAProject(Auth::id())]);
    }
}
