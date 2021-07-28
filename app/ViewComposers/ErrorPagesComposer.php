<?php

namespace App\ViewComposers;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use Illuminate\View\View;

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
