<?php

namespace App\Repository\CrowdSourcingProject;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectProblemStatusLkp;
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
        $language_id,
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
            })
            ->with('problems');

        // Load the translations related to the project, but only the one that equals to the language with id $language_id
        $builder = $builder->with(['translations' => function ($query) use ($language_id) {
            $query->where('language_id', $language_id);
        }]);

        if (count($additionalRelationships)) {
            $builder = $builder->with($additionalRelationships);
        }

        return $builder->get();
    }

    public function getActiveProjectsWithAtLeastOnePublishedProblemWithStatus(
        $language_id,
        $additionalRelationships = [], $problemStatusId = CrowdSourcingProjectProblemStatusLkp::PUBLISHED
    ): Collection {
        $builder = CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED])
            ->with('problems', function ($query) use ($problemStatusId) {
                $query->where(['status_id' => $problemStatusId]);
            });

        // Load the translations related to the project, but only the one that equals to the language with id $language_id
        $builder = $builder->with(['translations' => function ($query) use ($language_id) {
            $query->where('language_id', $language_id);
        }]);

        if (count($additionalRelationships)) {
            $builder = $builder->with($additionalRelationships);
        }

        return $builder->get();
    }

    public function getAllProjectsWithDefaultTranslation($additionalRelationships = []): Collection {
        $builder = CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED]);

        if (count($additionalRelationships)) {
            $builder = $builder->with($additionalRelationships);
        }

        return $builder->get();
    }

    public function getProjectsForProblems(): Collection {
        // get all projects that are not draft, not unpublished, and have at least one problem
        return CrowdSourcingProject::where('status_id', '!=', CrowdSourcingProjectStatusLkp::DRAFT)
            ->where('status_id', '!=', CrowdSourcingProjectStatusLkp::UNPUBLISHED)
            ->whereHas('problems')
            ->get();
    }
}
