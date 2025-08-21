<?php

declare(strict_types=1);

namespace App\ViewModels\CrowdSourcingProject;

class CrowdSourcingProjectSocialMediaMetadata {
    public function __construct(public $title, public $description, public $featuredImgPath, public $keywords, public $siteName) {}
}
