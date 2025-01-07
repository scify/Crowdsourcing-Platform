<?php

namespace App\ViewModels\CrowdSourcingProject;

use Illuminate\Support\Collection;

class CrowdSourcingProjects {
    /**
     * @var \Illuminate\Support\Collection
     */
    public $projects;

    public function __construct(Collection $projects) {
        $this->projects = $projects;
    }
}
