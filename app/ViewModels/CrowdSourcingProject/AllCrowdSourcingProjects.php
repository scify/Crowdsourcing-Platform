<?php

namespace App\ViewModels\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusLkp;
use Illuminate\Support\Collection;

class AllCrowdSourcingProjects {
    public function __construct(public Collection $projects) {}

    public function getProjectStatusCSSClass(CrowdSourcingProjectStatusLkp $status): string {
        return match ($status->id) {
            \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::DRAFT => 'badge-warning',
            \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::PUBLISHED => 'badge-success',
            \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED => 'badge-primary',
            \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::DELETED, \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::UNPUBLISHED => 'badge-danger',
            default => '',
        };
    }
}
