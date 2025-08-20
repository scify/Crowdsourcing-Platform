<?php

declare(strict_types=1);

namespace App\Repository\Problem;

use App\Models\Problem\ProblemTranslation;
use App\Repository\Repository;
use App\Repository\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\DB;

class ProblemTranslationRepository extends Repository {
    public function __construct(
        App $app,
        protected ProblemRepository $problemRepository
    ) {
        parent::__construct($app);
    }

    /**
     * {@inheritDoc}
     */
    public function getModelClassName(): string {
        return ProblemTranslation::class;
    }

    public function deleteTranslation($problem_id, $language_id): int {
        $problemDefaultTranslationId = $this->problemRepository->find($problem_id)->default_language_id;
        if ($language_id === $problemDefaultTranslationId) {
            throw new RepositoryException(sprintf("Cannot delete translation with ['problem_id' => %s, 'language_id' => %s] - it is the defaultTranslation for the problem.", $problem_id, $language_id));
        }

        return DB::delete('DELETE FROM problem_translations
                             WHERE problem_id = ? and language_id = ?;', [$problem_id, $language_id]);
    }
}
