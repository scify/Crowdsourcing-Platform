<?php

namespace App\Models\ViewModels;


class GamificationNextStep {

    public $title;
    public $subtitle;
    public $imgFileName;
    public $project;

    public function __construct($project, $title, $subtitle, $imgFileName) {
        $this->project = $project;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->imgFileName = $imgFileName;
    }


}