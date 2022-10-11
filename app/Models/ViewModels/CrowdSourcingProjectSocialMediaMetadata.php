<?php

namespace App\Models\ViewModels;

class CrowdSourcingProjectSocialMediaMetadata {
    public $title;
    public $description;
    public $featuredImgPath;
    public $keywords;
    public $siteName;

    public function __construct($title, $description, $featuredImgPath, $keywords, $siteName) {
        $this->title = $title;
        $this->description = $description;
        $this->featuredImgPath = $featuredImgPath;
        $this->keywords = $keywords;
        $this->siteName = $siteName;
    }
}
