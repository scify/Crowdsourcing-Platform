<?php


namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class AllCrowdSourcingProjects {

    public $projects;

    public function __construct(Collection $projects) {
        $this->projects = $projects;
    }

}
