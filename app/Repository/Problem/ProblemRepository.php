<?php

namespace App\Repository\Problem;

use App\BusinessLogicLayer\lkp\ProblemStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Problem\Problem;
use App\Repository\Repository;
use Illuminate\Support\Collection;

class ProblemRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return Problem::class;
    }

    public function getProjectWithProblemsByProjectSlug(string $project_slug): CrowdSourcingProject {
        return CrowdSourcingProject::where('slug', $project_slug)->with(['problems'])->first();
    }

    public function projectHasPublishedProblems(int $project_id): bool {
        $hasPublishedProblemsWithTranslations = Problem::where('project_id', $project_id)
            ->where('status_id', ProblemStatusLkp::PUBLISHED)
            ->whereHas('translations')
            ->exists();

        return $hasPublishedProblemsWithTranslations;
    }

    public function getProblemsForCrowdSourcingProjectForManagement(int $projectId): Collection {
        return Problem::where('project_id', $projectId)
            ->with(['defaultTranslation', 'translations', 'translations.language', 'status', 'bookmarks'])->get();
    }

    public function getProblemsForCrowdSourcingProjectForLandingPage(int $projectId, int $langId): Collection {
        return Problem::where('project_id', $projectId)
            ->where('status_id', ProblemStatusLkp::PUBLISHED)
            ->with(['defaultTranslation', 'translations' => function ($query) use ($langId) {
                $query->where('language_id', $langId);
            }, 'translations.language', 'bookmarks'])
            ->get()
            ->each(function ($problem) use ($langId) {
                $problem->currentTranslation = $problem->translations->firstWhere('language_id', $langId)
                    ?? $problem->defaultTranslation;
            });
    }

    public function getProblemsForManagement(int $projectId): Collection {
        $builder = Problem::where('project_id', $projectId)
            ->where('status_id', '!=', ProblemStatusLkp::DRAFT)
            ->where('status_id', '!=', ProblemStatusLkp::UNPUBLISHED)
            ->whereHas('solutions');

        return $builder->get();
    }
}
