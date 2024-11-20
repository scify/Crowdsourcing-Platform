<?php

namespace App\ViewModels\CrowdSourcingProject\Problem;

use App\Models\Language;
use App\Models\Problem\CrowdSourcingProjectProblem;
use Illuminate\Support\Collection;

class CreateEditProblem {
    public CrowdSourcingProjectProblem $problem;
    public $translations;
    public $problemStatusesLkp;
    public $languagesLkp;
    public $defaultLanguageCode = 'en';
    public $projects;
    public array $translationsMetaData;

    public function __construct(
        CrowdSourcingProjectProblem $crowdSourcingProjectProblem,
        Collection $translations,
        Collection $problemStatusesLkp,
        Collection $languagesLkp,
        Collection $projects
    ) {
        $this->problem = $crowdSourcingProjectProblem;
        $this->translations = $translations;
        $this->problemStatusesLkp = $problemStatusesLkp;
        $this->languagesLkp = $languagesLkp;
        $this->projects = $projects;
        $this->translationsMetaData = [
            'title' => [
                'display_title' => 'Project Name (*)',
                'required' => true,
            ],
            'description' => [
                'display_title' => 'Project description (*)',
                'required' => true,
            ],
        ];
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
