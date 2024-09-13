<?php

namespace App\Repository\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Repository\Repository;

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
}
