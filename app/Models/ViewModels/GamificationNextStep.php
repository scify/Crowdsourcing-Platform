<?php

namespace App\Models\ViewModels;


class GamificationNextStep {

    public $title;
    public $subtitle;
    public $imgFileName;
    public $project;
    public $projectHasActiveQuestionnaire;
    public $socialShareVM;

    public function __construct($project, $title, $subtitle, $imgFileName, $projectHasActiveQuestionnaire, QuestionnaireSocialShareButtons $socialShareVM) {
        $this->project = $project;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->imgFileName = $imgFileName;
        $this->projectHasActiveQuestionnaire = $projectHasActiveQuestionnaire;
        $this->socialShareVM = $socialShareVM;
    }


}