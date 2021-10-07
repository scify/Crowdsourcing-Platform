<?php

namespace App\Repository;


use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CrowdSourcingProjectRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName() {
        return CrowdSourcingProject::class;
    }

    public function getActiveProjectsWithAtLeastOneActiveQuestionnaire(): Collection {
        return CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED])
            ->whereHas('questionnaires', function (Builder $query) {
                $query->where(['status_id' => QuestionnaireStatusLkp::PUBLISHED]);
            })
            ->with('questionnaires', function ($query) {
                $query->select(['id', 'title', 'prerequisite_order', 'status_id', 'default_language_id',
                    'description', 'goal', 'statistics_page_visibility_lkp_id', 'questionnaires.created_at as questionnaire_created'])
                    ->where(['status_id' => QuestionnaireStatusLkp::PUBLISHED])
                    ->withCount('responses')
                    ->orderBy('prerequisite_order')
                    ->orderBy('questionnaire_created', 'desc');
            })
            ->get();
    }

    public function getPastProjects(): Collection {
        return CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::FINALIZED])->get();
    }
}
