<?php

namespace App\Models\ViewModels;


class GamificationNextStep {

    public $title;
    public $subtitle;
    public $imgFileName;
    public $project;
    public $projectHasActiveQuestionnaire;
    public $socialShareVM;
    public $userHasAlreadyAnsweredTheActiveQuestionnaire;

    public function __construct($project, $title, $imgFileName, $projectHasActiveQuestionnaire, $socialShareVM, $userHasAlreadyAnsweredTheActiveQuestionnaire) {
        $this->project = $project;
        $this->title = $title;
        $this->imgFileName = $imgFileName;
        $this->projectHasActiveQuestionnaire = $projectHasActiveQuestionnaire;
        $this->socialShareVM = $socialShareVM;
        $this->userHasAlreadyAnsweredTheActiveQuestionnaire = $userHasAlreadyAnsweredTheActiveQuestionnaire;
    }


}