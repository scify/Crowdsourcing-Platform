<?php

declare(strict_types=1);

namespace App\ViewModels\CrowdSourcingProject;

use Illuminate\Support\Collection;

class CrowdSourcingProjects {
    /**
     * @var Collection
     */
    public $projects;

    public function __construct(Collection $projects) {
        $this->projects = $projects;
    }
}
