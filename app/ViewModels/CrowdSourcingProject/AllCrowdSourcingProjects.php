<?php

declare(strict_types=1);

namespace App\ViewModels\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusLkp;
use Illuminate\Support\Collection;

class AllCrowdSourcingProjects {
    public function __construct(public Collection $projects) {}

    public function getProjectStatusCSSClass(CrowdSourcingProjectStatusLkp $status): string {
        return match ($status->id) {
            \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::DRAFT => 'text-bg-warning',
            \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::PUBLISHED => 'text-bg-success',
            \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED => 'text-bg-primary',
            \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::DELETED, \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::UNPUBLISHED => 'text-bg-danger',
            default => '',
        };
    }
}
