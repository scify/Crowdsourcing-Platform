<?php

namespace App\ViewComposers;

use Illuminate\View\View;
use App\BusinessLogicLayer\UserManager;

class MenuComposer {

    protected $userManager;

    public function __construct(UserManager $userManager) {
        $this->userManager = $userManager;
    }

    public function compose(View $view)
    {
        $view->with('userHasContributedToAProject', $this->userManager->userHasContributedToAProject(\Auth::user()));
    }
}