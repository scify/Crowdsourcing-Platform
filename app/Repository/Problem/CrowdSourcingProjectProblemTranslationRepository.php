<?php

namespace App\Repository\Problem;

use App\Models\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\Repository;
use App\Repository\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\DB;

class CrowdSourcingProjectProblemTranslationRepository extends Repository {
    protected $crowdSourcingProjectProblemRepository;

    public function __construct(
        App $app,
        CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository
    ) {
        parent::__construct($app);
        $this->crowdSourcingProjectProblemRepository = $crowdSourcingProjectProblemRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return CrowdSourcingProjectProblemTranslation::class;
    }

    public function deleteTranslation($problem_id, $language_id): int {
        $problemDefaultTranslationId = $this->crowdSourcingProjectProblemRepository->find($problem_id)->default_language_id;
        if ($language_id === $problemDefaultTranslationId) {
            throw new RepositoryException("Cannot delete translation with ['problem_id' => {$problem_id}, 'language_id' => {$language_id}] - it is the defaultTranslation for the problem.");
        }

        return DB::delete('DELETE FROM crowd_sourcing_project_problem_translations
                             WHERE problem_id = ? and language_id = ?;', [$problem_id, $language_id]);
    }
}
