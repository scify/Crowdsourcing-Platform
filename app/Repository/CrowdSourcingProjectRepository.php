<?php

namespace App\Repository;


use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CrowdSourcingProjectRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName()
    {
        return CrowdSourcingProject::class;
    }

    public function getActiveProjectsWithAtLeastOneActiveQuestionnaire(): Collection {
        return CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED])
            ->whereHas('questionnaires', function (Builder $query) {
                $query->where(['status_id' => QuestionnaireStatusLkp::PUBLISHED]);
            })
            ->get();
    }

    public function getPastProjects(): Collection {
        return CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::FINALIZED])->get();
    }
}
