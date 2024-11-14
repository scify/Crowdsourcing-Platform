<?php

namespace App\Repository\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectProblemStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Repository\Repository;
use Illuminate\Support\Collection;

class CrowdSourcingProjectProblemRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return CrowdSourcingProjectProblem::class;
    }

    public function getProjectWithProblemsByProjectSlug(string $project_slug): CrowdSourcingProject {
        return CrowdSourcingProject::where('slug', $project_slug)->with(['problems'])->first();
    }

    public function projectHasPublishedProblems(int $project_id): bool {
        $hasPublishedProblemsWithTranslations = CrowdSourcingProjectProblem::where('project_id', $project_id)
            ->where('status_id', CrowdSourcingProjectProblemStatusLkp::PUBLISHED)
            ->whereHas('translations')
            ->exists();

        return $hasPublishedProblemsWithTranslations;
    }

    public function getProblemsForCrowdSourcingProjectForManagement(int $projectId): Collection {
        return CrowdSourcingProjectProblem::where('project_id', $projectId)
            ->with(['defaultTranslation', 'translations', 'translations.language', 'status', 'bookmarks'])->get();
    }
}
