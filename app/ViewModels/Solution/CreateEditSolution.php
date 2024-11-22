<?php

namespace App\ViewModels\Solution;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Models\Problem\Problem;
use App\Models\Solution\Solution;
use Illuminate\Support\Collection;

class CreateEditSolution {
    public Solution $solution;
    public $translations;
    public $solutionStatusesLkp;
    public $languagesLkp;
    public $problem;
    public array $translationsMetaData;

    public function __construct(
        Solution $solution,
        Collection $translations,
        Collection $solutionStatusesLkp,
        Collection $languagesLkp,
        Problem $problem
    ) {
        $this->solution = $solution;
        $this->translations = $translations;
        $this->solutionStatusesLkp = $solutionStatusesLkp;
        $this->languagesLkp = $languagesLkp;
        $this->problem = $problem;
        $this->translationsMetaData = [
            'title' => [
                'display_title' => 'Solution title (*)',
                'required' => true,
            ],
            'description' => [
                'display_title' => 'Solution description (*)',
                'required' => true,
            ],
        ];
    }

    public function isEditMode(): bool {
        return $this->solution->id !== null;
    }

    public function isStatusTheDefault(int $status_id): bool {
        return $status_id === SolutionStatusLkp::UNPUBLISHED;
    }
}
