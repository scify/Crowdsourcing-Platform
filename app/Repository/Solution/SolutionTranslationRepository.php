<?php

namespace App\Repository\Solution;

use App\Models\Solution\SolutionTranslation;
use App\Repository\Repository;
use App\Repository\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\DB;

class SolutionTranslationRepository extends Repository {
    protected SolutionRepository $solutionRepository;

    public function __construct(
        App $app,
        SolutionRepository $solutionRepository
    ) {
        parent::__construct($app);
        $this->solutionRepository = $solutionRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return SolutionTranslation::class;
    }

    public function deleteTranslation($solution_id, $language_id): int {
        $solutionDefaultTranslationId = $this->solutionRepository->find($solution_id)->default_language_id;
        if ($language_id === $solutionDefaultTranslationId) {
            throw new RepositoryException("Cannot delete translation with ['solution_id' => {$solution_id}, 'language_id' => {$language_id}] - it is the defaultTranslation for the solution.");
        }

        return DB::delete('DELETE FROM solution_translations
                             WHERE solution_id = ? and language_id = ?;', [$solution_id, $language_id]);
    }
}
