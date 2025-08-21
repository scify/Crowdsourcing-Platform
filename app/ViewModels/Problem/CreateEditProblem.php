<?php

declare(strict_types=1);

namespace App\ViewModels\Problem;

use App\Models\Language;
use App\Models\Problem\Problem;
use Illuminate\Support\Collection;

class CreateEditProblem {
    /**
     * @var \Illuminate\Support\Collection
     */
    public $translations;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $problemStatusesLkp;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $languagesLkp;

    public $defaultLanguageCode = 'en';

    /**
     * @var \Illuminate\Support\Collection
     */
    public $projects;

    public array $translationsMetaData = [
        'title' => [
            'display_title' => 'Project Name (*)',
            'required' => true,
        ],
        'description' => [
            'display_title' => 'Project description (*)',
            'required' => true,
        ],
    ];

    public function __construct(
        public Problem $problem,
        Collection $translations,
        Collection $problemStatusesLkp,
        Collection $languagesLkp,
        Collection $projects
    ) {
        $this->translations = $translations;
        $this->problemStatusesLkp = $problemStatusesLkp;
        $this->languagesLkp = $languagesLkp;
        $this->projects = $projects;
    }

    public function isEditMode(): bool {
        return $this->problem->id !== null;
    }

    public function shouldLanguageBeSelected(Language $language): bool {
        if ($this->problem->default_language_id) {
            return $this->problem->default_language_id == $language->id;
        }

        return $language->language_code === $this->defaultLanguageCode;
    }
}
