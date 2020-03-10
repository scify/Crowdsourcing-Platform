<?php

namespace App\ViewComposers;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\BusinessLogicLayer\UserManager;

class ErrorPagesComposer {

    protected $crowdSourcingProjectManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager) {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function compose(View $view)
    {
        $view->with(['projects' => $this->crowdSourcingProjectManager->getCrowdSourcingProjectsForHomePage()]);
    }
}
