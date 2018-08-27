<?php

namespace App\Models\ViewModels;


class GamificationNextStep {

    public $title;
    public $subtitle;
    public $imgFileName;


    public function __construct($title, $subtitle, $imgFileName) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->imgFileName = $imgFileName;
    }


}