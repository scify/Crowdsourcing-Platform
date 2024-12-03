<?php

namespace App\Repository\Solution;

use App\Models\Solution\Solution;
use App\Repository\Problem\ProblemRepository;
use App\Repository\Repository;
use Illuminate\Support\Collection;

class SolutionRepository extends Repository {
    protected ProblemRepository $problemRepository;

    public function __construct(ProblemRepository $problemRepository) {
        $this->problemRepository = $problemRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return Solution::class;
    }

    public function getSolutionsForManagementFilteredByProjectIds($idsArray): Collection {
        $finalSolutionsCollection = new Collection;
        foreach ($idsArray as $project_id) {
            $problemIdsBelongingToProject = $this->problemRepository->getProblemsForCrowdSourcingProjectForManagement($project_id)->pluck('id');
            foreach ($problemIdsBelongingToProject as $problem_id) {
                // $finalSolutionsCollection = $finalSolutionsCollection->merge(Solution::where('problem_id', $problem_id)->get());
                $finalSolutionsCollection = $finalSolutionsCollection->merge(Solution::where('problem_id', $problem_id)->with(['problem'])->get()); // bookmark4 - do we need/want with each solution's problem?
            }
        }

        return $finalSolutionsCollection;
    }

    public function getSolutionsForManagementFilteredByProblemIds($idsArray): Collection {
        $finalSolutionsCollection = new Collection;
        foreach ($idsArray as $problem_id) {
            // $finalSolutionsCollection = $finalSolutionsCollection->merge(Solution::where('problem_id', $problem_id)->get());
            $finalSolutionsCollection = $finalSolutionsCollection->merge(Solution::where('problem_id', $problem_id)->with(['problem'])->get()); // bookmark4 - do we need/want with each solution's problem?
        }

        return $finalSolutionsCollection;
    }
}
