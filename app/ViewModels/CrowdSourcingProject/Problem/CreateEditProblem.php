<?php

namespace App\ViewModels\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\Language;
use Illuminate\Support\Collection;

class CreateEditProblem {
    public CrowdSourcingProjectProblem $problem;
    public $translations;
    public $problemStatusesLkp;
    public $languagesLkp;
    public $defaultLanguageCode = 'en';
    public $projects;

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
