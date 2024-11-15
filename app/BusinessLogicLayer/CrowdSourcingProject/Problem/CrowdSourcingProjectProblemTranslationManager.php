<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemRepository;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslationRepository;
use App\Repository\LanguageRepository;
use Illuminate\Support\Collection;

class CrowdSourcingProjectProblemTranslationManager {
    protected $crowdSourcingProjectProblemTranslationRepository;
    protected $languageRepository;
    protected $crowdSourcingProjectProblemRepository;

    public function __construct(
        CrowdSourcingProjectProblemTranslationRepository $crowdSourcingProjectProblemTranslationRepository,
        LanguageRepository $languageRepository,
        CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository
    ) {
        $this->crowdSourcingProjectProblemTranslationRepository = $crowdSourcingProjectProblemTranslationRepository;
        $this->languageRepository = $languageRepository;
        $this->crowdSourcingProjectProblemRepository = $crowdSourcingProjectProblemRepository;
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

    /**
     * Get all the translations for a problem.
     *
     * This function accepts either an integer ID or an instance of the
     * CrowdSourcingProjectProblem class and returns a Collection object
     * with all of the problems defined translations.
     *
     * @param int|CrowdSourcingProjectProblem $input An integer ID or a CrowdSourcingProjectProblem object.
     */
    public function getTranslationsForProblem(int|CrowdSourcingProjectProblem $input): Collection {
        if (gettype($input) !== 'integer') {
            $id = $input->id;
        } else {
            $id = $input;
        }

        if (!$id) {
            return new Collection;
        }

        return $this->crowdSourcingProjectProblemTranslationRepository->allWhere(['problem_id' => $id]);
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

    protected function updateProblemExtraTranslations(int $problemId, array $newExtraTranslations) {
        $problemDefaultTranslationId = $this->crowdSourcingProjectProblemRepository->find($problemId)->default_language_id;
        $oldExtraTranslations = $this->getTranslationsForProblem($problemId)->whereNotIn('language_id', $problemDefaultTranslationId);
        $alreadyUpdatedExtraTranslations = [];

        foreach ($oldExtraTranslations as $oldExtraTranslation) { // for each of the already existing translations
            if ($this->translationExistsInTranslationsArray($oldExtraTranslation, $newExtraTranslations)) { // if there is a new translation, update the already existing translation in DB
                $newExtraTranslation = $this->getTranslationFromTranslationsArrayViaLanguageId($newExtraTranslations, $oldExtraTranslation->language_id);
                $this->crowdSourcingProjectProblemTranslationRepository->update(
                    [
                        'problem_id' => $problemId,
                        'language_id' => $oldExtraTranslation['language_id'],
                        'title' => $newExtraTranslation->title,
                        'description' => $newExtraTranslation->description,
                    ],
                    [
                        'problem_id' => $problemId,
                        'language_id' => $oldExtraTranslation['language_id'],
                    ],
                    [
                        'problem_id' => $problemId,
                        'language_id' => $oldExtraTranslation['language_id'],
                    ]
                );

                $alreadyUpdatedExtraTranslations[] = $newExtraTranslation; // keep track that the translation has already been updated in the DB
            } else { // else delete the already existing translation from the DB
                $this->crowdSourcingProjectProblemTranslationRepository->deleteTranslation($problemId, $oldExtraTranslation['language_id']);
            }
        }

        foreach ($newExtraTranslations as $newExtraTranslation) { // for each of the new translations
            if (!$this->translationExistsInTranslationsArray($newExtraTranslation, $alreadyUpdatedExtraTranslations)) { // if not already updated, create the record in the DB
                $this->crowdSourcingProjectProblemTranslationRepository->create(
                    [
                        'problem_id' => $problemId,
                        'language_id' => $newExtraTranslation->language_id,
                        'title' => $newExtraTranslation->title,
                        'description' => $newExtraTranslation->description,
                    ],
                );
            }
        }
    }

    protected function translationExistsInTranslationsArray($inputTranslation, array $translations): bool {
        foreach ($translations as $translation) {
            if ($translation->language_id === $inputTranslation->language_id) {
                return true;
            }
        }

        return false;
    }

    protected function getTranslationFromTranslationsArrayViaLanguageId(array $translations, int $id): object {
        foreach ($translations as $translation) {
            if ($translation->language_id === $id) {
                return $translation;
            }
        }

        return null;
    }
}
