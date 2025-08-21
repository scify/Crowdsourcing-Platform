<?php

declare(strict_types=1);

namespace App\Repository\Solution;

use App\Models\Solution\SolutionTranslation;
use App\Repository\Repository;
use App\Repository\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\DB;

class SolutionTranslationRepository extends Repository {
    public function __construct(
        App $app,
        protected SolutionRepository $solutionRepository
    ) {
        parent::__construct($app);
    }

    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return SolutionTranslation::class;
    }

    public function deleteTranslation($solution_id, $language_id): int {
        $solutionDefaultTranslationId = $this->solutionRepository->find($solution_id)->default_language_id;
        if ($language_id === $solutionDefaultTranslationId) {
            throw new RepositoryException(sprintf("Cannot delete translation with ['solution_id' => %s, 'language_id' => %s] - it is the defaultTranslation for the solution.", $solution_id, $language_id));
        }

        return DB::delete('DELETE FROM solution_translations
                             WHERE solution_id = ? and language_id = ?;', [$solution_id, $language_id]);
    }
}
