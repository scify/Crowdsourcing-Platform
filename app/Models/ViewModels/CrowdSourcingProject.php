<?php

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class CrowdSourcingProject {

    public $project;
    public $creator_name;
    public $updated_at;
    public $logo_path;
    public $name;
    public $motto;
    public $publicUrl;

    public function __construct(\App\Models\CrowdSourcingProject $project) {
        $this->project = $project;
        $this->creator_name = $project->creator->name;
        $this->updated_at = $project->updated_at;
        $this->logo_path = $project->logo_path;
        $this->name = $project->name;
        $this->motto = $project->motto;
        $this->publicUrl = "";
    }

}