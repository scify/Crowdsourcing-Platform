<?php

namespace App\Repository\Problem;

use App\Models\Problem\ProblemTranslation;
use App\Repository\Repository;
use App\Repository\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\DB;

class ProblemTranslationRepository extends Repository {
    protected ProblemRepository $problemRepository;

    public function __construct(
        App $app,
        ProblemRepository $crowdSourcingProjectProblemRepository
    ) {
        parent::__construct($app);
        $this->problemRepository = $crowdSourcingProjectProblemRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return ProblemTranslation::class;
    }

    public function deleteTranslation($problem_id, $language_id): int {
        $problemDefaultTranslationId = $this->problemRepository->find($problem_id)->default_language_id;
        if ($language_id === $problemDefaultTranslationId) {
            throw new RepositoryException("Cannot delete translation with ['problem_id' => {$problem_id}, 'language_id' => {$language_id}] - it is the defaultTranslation for the problem.");
        }

        return DB::delete('DELETE FROM problem_translations
                             WHERE problem_id = ? and language_id = ?;', [$problem_id, $language_id]);
    }
}
