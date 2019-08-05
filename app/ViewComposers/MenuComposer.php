<?php

namespace App\ViewComposers;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use Illuminate\View\View;
use App\BusinessLogicLayer\UserManager;

class MenuComposer {

    protected $userManager;
    protected $crowdsourcingProjectManager;

    public function __construct(UserManager $userManager, CrowdSourcingProjectManager $crowdSourcingProjectManager) {
        $this->userManager = $userManager;
        $this->crowdsourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function compose(View $view)
    {
        $defaultProject = $this->crowdsourcingProjectManager->getDefaultCrowdsourcingProject();
        $view->with(['userHasContributedToAProject' => $this->userManager->userHasContributedToAProject(\Auth::id()),
                     'defaultProject' => $defaultProject]);
    }
}