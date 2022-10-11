<?php

namespace App\Models\ViewModels;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusLkp;
use Illuminate\Support\Collection;

class AllCrowdSourcingProjects {
    public $projects;

    public function __construct(Collection $projects) {
        $this->projects = $projects;
    }

    public function getProjectStatusCSSClass(CrowdSourcingProjectStatusLkp $status): string {
        switch ($status->id) {
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::DRAFT:
                return 'badge-warning';
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::PUBLISHED:
                return 'badge-success';
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED:
                return 'badge-primary';
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::DELETED:
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::UNPUBLISHED:
                return 'badge-danger';
            default:
                return '';
        }
    }
}
