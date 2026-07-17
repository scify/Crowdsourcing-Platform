<?php

declare(strict_types=1);

namespace App\Repository\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Repository\Repository;
use App\Repository\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\DB;

class CrowdSourcingProjectTranslationRepository extends Repository {
    public function __construct(
        App $app,
        protected CrowdSourcingProjectRepository $crowdSourcingProjectRepository
    ) {
        parent::__construct($app);
    }

    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return CrowdSourcingProjectTranslation::class;
    }

    public function deleteTranslation($project_id, $language_id): int {
        $projectDefaultLanguageId = $this->crowdSourcingProjectRepository->find($project_id)->language_id;
        if ($language_id === $projectDefaultLanguageId) {
            throw new RepositoryException(sprintf("Cannot delete translation with ['project_id' => %s, 'language_id' => %s] - it is the defaultTranslation for the project.", $project_id, $language_id));
        }

        return DB::delete('DELETE FROM crowd_sourcing_project_translations
                             WHERE project_id = ? and language_id = ?;', [$project_id, $language_id]);
    }
}
