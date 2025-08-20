<?php

declare(strict_types=1);

namespace App\ViewModels\Solution;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Models\Problem\Problem;
use App\Models\Solution\Solution;
use Illuminate\Support\Collection;

class CreateEditSolution {
    /**
     * @var \Illuminate\Support\Collection
     */
    public $translations;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $solutionStatusesLkp;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $languagesLkp;

    /**
     * @var \App\Models\Problem\Problem
     */
    public $problem;

    public array $translationsMetaData = [
        'title' => [
            'display_title' => 'Solution title (*)',
            'required' => true,
        ],
        'description' => [
            'display_title' => 'Solution description (*)',
            'required' => true,
        ],
    ];

    public function __construct(
        public Solution $solution,
        Collection $translations,
        Collection $solutionStatusesLkp,
        Collection $languagesLkp,
        Problem $problem
    ) {
        $this->translations = $translations;
        $this->solutionStatusesLkp = $solutionStatusesLkp;
        $this->languagesLkp = $languagesLkp;
        $this->problem = $problem;
    }

    public function isEditMode(): bool {
        return $this->solution->id !== null;
    }

    public function isStatusTheDefault(int $status_id): bool {
        return $status_id === SolutionStatusLkp::UNPUBLISHED;
    }
}
