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

    public function getActiveProjectsWithAtLeastOneQuestionnaireWithStatus(
        $additionalRelationships = [], $questionnaireStatusId = QuestionnaireStatusLkp::PUBLISHED
    ): Collection {
        $builder = CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED])
            ->whereHas('questionnaires', function (Builder $query) use ($questionnaireStatusId) {
                $query->where(['status_id' => $questionnaireStatusId]);
            })
            ->with('questionnaires', function ($query) use ($questionnaireStatusId) {
                $query->select(['id', 'prerequisite_order', 'status_id', 'default_language_id',
                    'goal', 'statistics_page_visibility_lkp_id', 'questionnaires.created_at as questionnaire_created'])
                    ->where(['status_id' => $questionnaireStatusId])
                    ->withCount('responses')
                    ->orderBy('prerequisite_order')
                    ->orderBy('questionnaire_created', 'desc');
            });

        if (count($additionalRelationships))
            $builder = $builder->with($additionalRelationships);

        return $builder->get();
    }

    public function getPastProjects(): Collection {
        return CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::FINALIZED])->get();
    }
}
