<?php

namespace App\Repository;


use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\Models\CrowdSourcingProject;
use Illuminate\Database\Eloquent\Builder;

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

    public function getActiveProjectsWithAtLeastOneActiveQuestionnaire() {
        return CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED])
            ->whereHas('questionnaires', function (Builder $query) {
                $query->where(['status_id' => QuestionnaireStatusLkp::PUBLISHED]);
            })
            ->get();
    }
}
