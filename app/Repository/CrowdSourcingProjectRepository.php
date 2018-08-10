<?php

namespace App\Repository;


use App\Models\CrowdSourcingProject;

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

    public function getProjectWithStatusAndQuestionnaires()
    {
        return $this->getModelInstance()->with('questionnaires')->with('questionnaires.statusHistory')->with('questionnaires.statusHistory.status')->get();
    }
}