<?php

declare(strict_types=1);

namespace App\ViewModels\Solution;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Language;
use App\Models\Problem\Problem;
use App\Models\User\User;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectLayoutPage;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class ProposeSolutionPage extends CrowdSourcingProjectLayoutPage {
    public string $page_title;

    public function __construct(
        CrowdSourcingProject $project,
        public Problem $problem,
        public Language $language,
    ) {
        parent::__construct($project);
        $this->page_title = $project->currentTranslation->name . ' | ' . $this->problem->currentTranslation->title . ' ➔ ' . __('solution.propose_solution');
    }

    public function getLoggedInUser(): User|Authenticatable|null {
        return Auth::user();
    }

    public function getLocale(): string {
        return app()->getLocale();
    }
}
