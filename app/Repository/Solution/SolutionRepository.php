<?php

declare(strict_types=1);

namespace App\Repository\Solution;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Models\Solution\Solution;
use App\Repository\Repository;
use Illuminate\Support\Collection;

class SolutionRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return Solution::class;
    }

    public function getSolutionsForManagementFilteredByProjectIds($problemIds): Collection {
        $finalSolutionsCollection = new Collection;
        $relationships = ['defaultTranslation', 'translations', 'translations.language', 'creator', 'status', 'upvotes'];

        foreach ($problemIds as $problem_id) {
            $finalSolutionsCollection = $finalSolutionsCollection->merge(
                Solution::where('problem_id', $problem_id)
                    ->with($relationships)
                    ->withCount('upvotes as upvotes_count')
                    ->orderByDesc('upvotes_count')
                    ->get()
            );
        }

        return $finalSolutionsCollection;
    }

    public function getSolutionsForManagementFilteredByProblemIds($idsArray): Collection {
        $finalSolutionsCollection = new Collection;
        $relationships = ['defaultTranslation', 'translations', 'translations.language', 'creator', 'status', 'upvotes'];
        foreach ($idsArray as $problem_id) {
            $finalSolutionsCollection = $finalSolutionsCollection->merge(
                Solution::where('problem_id', $problem_id)
                    ->with($relationships)
                    ->withCount('upvotes as upvotes_count')
                    ->orderByDesc('upvotes_count')
                    ->get()
            );
        }

        return $finalSolutionsCollection;
    }

    public function getSolutions(int $problem_id, int $lang_id, ?int $current_user_id): Collection {
        return Solution::where('problem_id', $problem_id)
            ->where('status_id', SolutionStatusLkp::PUBLISHED)
            ->with(['defaultTranslation', 'translations'])
            ->withCount('upvotes as upvotes_count')
            ->get()
            ->each(function ($solution) use ($lang_id, $current_user_id): void {
                $solution->current_translation = $solution->translations->firstWhere('language_id', $lang_id)
                    ?? $solution->defaultTranslation;
                if ($current_user_id !== null) {
                    $solution->upvoted_by_current_user = $solution->upvotes->contains('user_voter_id', $current_user_id);
                } else {
                    $solution->upvoted_by_current_user = false;
                }
            });
    }

    public function getSolutionsForProblems(array $problem_ids): Collection {
        return Solution::whereIn('problem_id', $problem_ids)->get();
    }

    public function getPublishedSolutionsProposedByUser(int $userId): Collection {
        return Solution::where('user_creator_id', $userId)->where('status_id', SolutionStatusLkp::PUBLISHED)->get();
    }

    public function getSolutionsByProjectId(int $project_id): Collection {
        return Solution::whereHas('problem', function ($query) use ($project_id): void {
            $query->where('project_id', $project_id);
        })->with(['problem.defaultTranslation', 'upvotes.user', 'creator'])->get();
    }
}
