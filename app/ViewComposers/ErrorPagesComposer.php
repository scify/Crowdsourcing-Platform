<?php

declare(strict_types=1);

namespace App\ViewComposers;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use Illuminate\View\View;

class ErrorPagesComposer {
    public function __construct(protected CrowdSourcingProjectManager $crowdSourcingProjectManager) {}

    public function compose(View $view): void {
        $view->with(['projects' => $this->crowdSourcingProjectManager->getCrowdSourcingProjectsForHomePage()]);
    }
}
