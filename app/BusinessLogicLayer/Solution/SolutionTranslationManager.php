<?php

namespace App\BusinessLogicLayer\Solution;

use App\Models\Solution\Solution;
use App\Repository\Solution\SolutionTranslationRepository;
use Illuminate\Support\Collection;

class SolutionTranslationManager {
    protected SolutionTranslationRepository $solutionTranslationRepository;

    public function __construct(
        SolutionTranslationRepository $solutionTranslationRepository,
    ) {
        $this->solutionTranslationRepository = $solutionTranslationRepository;
    }

    /**
     * Get all the translations for a solution.
     *
     * This function accepts either an integer ID or an instance of the
     * Solution class and returns a Collection object
     * with all of the solution's defined translations.
     *
     * @param int|Solution $input An integer ID or a Solution object.
     */
    public function getTranslationsForSolution(int|Solution $input): Collection {
        if (gettype($input) !== 'integer') {
            $id = $input->id;
        } else {
            $id = $input;
        }

        if (!$id) {
            return new Collection;
        }

        return $this->solutionTranslationRepository->allWhere(['solution_id' => $id]);
    }
}
