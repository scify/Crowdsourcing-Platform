<?php

namespace App\Repository\Solution;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Models\Solution\Solution;
use App\Repository\Repository;
use Illuminate\Support\Collection;

class SolutionRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return Solution::class;
    }

    public function getSolutionsForManagementFilteredByProjectIds($problemIds): Collection {
        $finalSolutionsCollection = new Collection;
        $relationships = ['defaultTranslation', 'translations', 'translations.language', 'user', 'status'];

        foreach ($problemIds as $problem_id) {
            $finalSolutionsCollection = $finalSolutionsCollection->merge(Solution::where('problem_id', $problem_id)->with($relationships)
                ->withCount('upvotes as upvotes_count')->get());
        }

        return $finalSolutionsCollection;
    }

    public function getSolutionsForManagementFilteredByProblemIds($idsArray): Collection {
        $finalSolutionsCollection = new Collection;
        $relationships = ['defaultTranslation', 'translations', 'translations.language', 'user', 'status'];
        foreach ($idsArray as $problem_id) {
            $finalSolutionsCollection = $finalSolutionsCollection->merge(Solution::where('problem_id', $problem_id)->with($relationships)
                ->withCount('upvotes as upvotes_count')->get());
        }

        return $finalSolutionsCollection;
    }

    public function getSolutions(int $problem_id, int $lang_id, ?int $current_user_id): Collection {
        return Solution::where('problem_id', $problem_id)
            ->where('status_id', SolutionStatusLkp::PUBLISHED)
            ->with(['defaultTranslation', 'translations'])
            ->withCount('upvotes as upvotes_count')
            ->get()
            ->each(function ($solution) use ($lang_id, $current_user_id) {
                $solution->current_translation = $solution->translations->firstWhere('language_id', $lang_id)
                    ?? $solution->defaultTranslation;
                if ($current_user_id !== null) {
                    $solution->upvoted_by_current_user = $solution->upvotes->contains('user_voter_id', $current_user_id);
                } else {
                    $solution->upvoted_by_current_user = false;
                }
            });
    }
}
