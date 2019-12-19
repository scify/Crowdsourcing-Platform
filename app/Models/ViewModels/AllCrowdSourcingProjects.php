<?php


namespace App\Models\ViewModels;


use App\Models\CrowdSourcingProjectStatusLkp;
use Illuminate\Support\Collection;

class AllCrowdSourcingProjects {

    public $projects;

    public function __construct(Collection $projects) {
        $this->projects = $projects;
    }

    public function getProjectStatusCSSClass(CrowdSourcingProjectStatusLkp $status) {
        switch ($status->id) {
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::DRAFT:
                return 'draft';
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::PUBLISHED:
                return 'published';
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED:
                return 'finalized';
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::UNPUBLISHED:
                return 'unpublished';
            case \App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::DELETED:
                return 'deleted';
            default:
                return '';
        }
    }
}
