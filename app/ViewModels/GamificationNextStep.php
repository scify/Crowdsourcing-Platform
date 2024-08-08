<?php

namespace App\ViewModels;

use Illuminate\Support\Collection;

class GamificationNextStep {
    public $title;
    public $subtitle;
    public $imgFileName;
    public $projects;
    public $projectHasActiveQuestionnaire;
    public $socialShareVM;
    public $userHasAlreadyAnsweredTheActiveQuestionnaire;

    public function __construct(Collection $projects, $title, $imgFileName, $projectHasActiveQuestionnaire, $socialShareVM, $userHasAlreadyAnsweredTheActiveQuestionnaire) {
        $this->projects = $projects;
        $this->title = $title;
        $this->imgFileName = $imgFileName;
        $this->projectHasActiveQuestionnaire = $projectHasActiveQuestionnaire;
        $this->socialShareVM = $socialShareVM;
        $this->userHasAlreadyAnsweredTheActiveQuestionnaire = $userHasAlreadyAnsweredTheActiveQuestionnaire;
    }
}
