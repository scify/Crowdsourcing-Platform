<?php

namespace App\Repository\CrowdSourcingProject;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Repository\Repository;
use Illuminate\Support\Collection;

class CrowdSourcingProjectRepository extends Repository {
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function getModelClassName() {
        return CrowdSourcingProject::class;
    }

    public function getActiveProjectsWithAtLeastOneQuestionnaireWithStatus(
        $additionalRelationships = [], $questionnaireStatusId = QuestionnaireStatusLkp::PUBLISHED
    ): Collection {
        $builder = CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED])
            ->with('questionnaires', function ($query) use ($questionnaireStatusId) {
                $query->select(['id', 'prerequisite_order', 'status_id', 'default_language_id',
                    'goal', 'statistics_page_visibility_lkp_id', 'questionnaires.created_at as questionnaire_created', ])
                    ->where(['status_id' => $questionnaireStatusId])
                    ->withCount('responses')
                    ->orderBy('prerequisite_order')
                    ->orderBy('questionnaire_created', 'desc');
            })->with('problems');

        if (count($additionalRelationships)) {
            $builder = $builder->with($additionalRelationships);
        }

        return $builder->get();
    }
}
