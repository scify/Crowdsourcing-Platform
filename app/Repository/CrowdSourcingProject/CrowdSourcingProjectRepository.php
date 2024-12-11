<?php

namespace App\Repository\CrowdSourcingProject;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\ProblemStatusLkp;
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

    public function getActiveProjectsForHomePage(
        $language_id,
        $additionalRelationships = [], $questionnaireStatusId = QuestionnaireStatusLkp::PUBLISHED
    ): Collection {
        // First query to get projects with published status and their questionnaires
        $builder1 = CrowdSourcingProject::where(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED])
            ->with('questionnaires', function ($query) use ($questionnaireStatusId) {
                $query->select(['id', 'prerequisite_order', 'status_id', 'default_language_id',
                    'goal', 'statistics_page_visibility_lkp_id', 'questionnaires.created_at as questionnaire_created'])
                    ->where(['status_id' => $questionnaireStatusId])
                    ->withCount('responses')
                    ->orderBy('prerequisite_order')
                    ->orderBy('questionnaire_created', 'desc');
            })
            ->with('problems')
            ->with(['translations' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            }]);

        // Add additional relationships if provided
        if (count($additionalRelationships)) {
            $builder1 = $builder1->with($additionalRelationships);
        }

        // Second query to get projects that have at least one published problem
        $builder2 = CrowdSourcingProject::whereHas('problems', function ($query) {
            $query->where(['status_id' => ProblemStatusLkp::PUBLISHED]);
        })
            ->with(['translations' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            }]);

        // Add additional relationships if provided
        if (count($additionalRelationships)) {
            $builder2 = $builder2->with($additionalRelationships);
        }

        // Combine the results of both queries, remove duplicates, and order by the most recent one
        return $builder1->union($builder2)->distinct('id')->orderBy('created_at', 'desc')->get();
    }

    public function getActiveProjectsWithAtLeastOnePublishedProblemWithStatus(
        $language_id,
        $additionalRelationships = [], $problemStatusId = ProblemStatusLkp::PUBLISHED
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

    public function getProjectsForManagement(?int $user_creator_id): Collection {
        $builder = CrowdSourcingProject::where('status_id', '!=', CrowdSourcingProjectStatusLkp::DRAFT)
            ->where('status_id', '!=', CrowdSourcingProjectStatusLkp::UNPUBLISHED)
            ->whereHas('problems');

        if (!is_null($user_creator_id)) {
            $builder->where('user_creator_id', $user_creator_id);
        }

        return $builder->get();
    }
}
