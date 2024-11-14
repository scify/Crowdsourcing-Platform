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

    public function updateProblemTranslations(int $problemId, array $defaultTranslation, array $extraTranslations): void {
        $this->updateProblemDefaultTranslation($problemId, $defaultTranslation);

        $this->updateProblemExtraTranslations($problemId, $extraTranslations);
    }

    protected function updateProblemDefaultTranslation(int $problemId, array $defaultTranslation): void {
        $this->crowdSourcingProjectProblemTranslationRepository->updateOrCreate(
            [
                'problem_id' => $problemId,
                'language_id' => $defaultTranslation['language_id'],
            ],
            [
                'title' => $defaultTranslation['title'],
                'description' => $defaultTranslation['description'],
            ]
        );
    }

    protected function updateProblemExtraTranslations(int $problemId, array $extraTranslations) {
        // TODO
        // get all available translations for problem
        // for each translation in the existing ones, check if the translation exists in the $extraTranslations array
        // if exists
        // update the title and description
        // remove the entry from the $extraTranslations array (or mark it as parsed)
        // if not exists
        // delete the record in the DB

        // foreach translation in the $extraTranslations
        // if not parsed, create the record in the DB
    }
}
