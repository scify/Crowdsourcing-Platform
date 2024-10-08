<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslationRepository;
use App\Repository\LanguageRepository;

class CrowdSourcingProjectProblemTranslationManager {
    protected $crowdSourcingProjectProblemTranslationRepository;
    protected $languageRepository;

    public function __construct(CrowdSourcingProjectProblemTranslationRepository $crowdSourcingProjectProblemTranslationRepository,
        LanguageRepository $languageRepository) {
        $this->crowdSourcingProjectProblemTranslationRepository = $crowdSourcingProjectProblemTranslationRepository;
        $this->languageRepository = $languageRepository;
    }

    public function getFieldsTranslationForProjectProblem(CrowdSourcingProjectProblem $projectProblem): CrowdSourcingProjectProblemTranslation {
        $language = $this->languageRepository->where(['language_code' => app()->getLocale()]);
        if (!$language) {
            return $projectProblem->defaultTranslation;
        }
        $fieldsTranslation = $this->crowdSourcingProjectProblemTranslationRepository->where([
            'problem_id' => $projectProblem->id,
            'language_id' => $language->id,
        ]);

        return $fieldsTranslation ?: $projectProblem->defaultTranslation;
    }
}
