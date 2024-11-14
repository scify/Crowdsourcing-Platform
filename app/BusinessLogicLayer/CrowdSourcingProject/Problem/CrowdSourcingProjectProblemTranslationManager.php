<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslationRepository;
use App\Repository\LanguageRepository;
use Illuminate\Support\Collection;

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

    public function getTranslationsForProblem(CrowdSourcingProjectProblem $problem): Collection {
        if (!$problem->id) {
            return new Collection;
        }

        return $this->crowdSourcingProjectProblemTranslationRepository->allWhere(['problem_id' => $problem->id]);
    }

    public function updateProblemTranslations(int $problem_id, int $new_default_language_id, string $default_language_title, string $default_language_description) {
        $this->crowdSourcingProjectProblemTranslationRepository->updateOrCreate(
            [
                'problem_id' => $problem_id,
                'language_id' => $new_default_language_id,
            ],
            [
                'title' => $default_language_title,
                'description' => $default_language_description,
            ]
        );
    }
}
