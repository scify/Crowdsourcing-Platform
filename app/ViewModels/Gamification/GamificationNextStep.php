<?php

namespace App\ViewModels\Gamification;

use Illuminate\Support\Collection;

class GamificationNextStep {
    public $subtitle;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $projects;

    public function __construct(Collection $projects, public $title, public $imgFileName, public $projectHasActiveQuestionnaire, public $socialShareVM, public $userHasAlreadyAnsweredTheActiveQuestionnaire) {
        $this->projects = $projects;
    }
}
