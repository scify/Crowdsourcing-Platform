<?php

namespace App\ViewModels\CrowdSourcingProject;

use Illuminate\Support\Collection;

class CrowdSourcingProjects {
    public $projects;

    public function __construct(Collection $projects) {
        $this->projects = $projects;
    }
}
