<?php

namespace App\ViewComposers;

use Illuminate\View\View;

class ErrorPagesComposer {
    public function __construct(protected \App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager $crowdSourcingProjectManager) {}

    public function compose(View $view): void {
        $view->with(['projects' => $this->crowdSourcingProjectManager->getCrowdSourcingProjectsForHomePage()]);
    }
}
