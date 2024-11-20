<?php

namespace App\BusinessLogicLayer\Problem;

use App\Models\Problem\CrowdSourcingProjectProblem;
use App\Models\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\LanguageRepository;
use App\Repository\Problem\CrowdSourcingProjectProblemRepository;
use App\Repository\Problem\CrowdSourcingProjectProblemTranslationRepository;
use App\Repository\RepositoryException;
use Exception;
use Illuminate\Support\Collection;

class CrowdSourcingProjectProblemTranslationManager {
    protected CrowdSourcingProjectProblemTranslationRepository $crowdSourcingProjectProblemTranslationRepository;
    protected LanguageRepository $languageRepository;
    protected CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository;

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

    /**
     * @throws RepositoryException
     */
    public function updateProblemTranslations(int $problemId, array $defaultTranslation, array $extraTranslations): void {
        $this->updateProblemDefaultTranslation($problemId, $defaultTranslation);

        $this->updateProblemExtraTranslations($problemId, $extraTranslations);
    }

    /**
     * Updates the default translation for a problem.
     */
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

    /**
     * Updates the extra translations for a problem.
     *
     * @throws \App\Repository\RepositoryException
     */
    protected function updateProblemExtraTranslations(int $problemId, array $newExtraTranslations): void {
        $problemDefaultTranslationId = $this->crowdSourcingProjectProblemRepository->find($problemId)->default_language_id;
        $oldExtraTranslations = $this->getTranslationsForProblem($problemId)->whereNotIn('language_id', $problemDefaultTranslationId);
        $alreadyUpdatedExtraTranslations = [];

        // for each of the already existing translations
        foreach ($oldExtraTranslations as $oldExtraTranslation) {
            // if there is a new translation, update the already existing translation in DB
            if ($this->translationExistsInTranslationsArray($oldExtraTranslation, $newExtraTranslations)) {
                $newExtraTranslation = $this->getTranslationFromTranslationsArrayViaLanguageId($newExtraTranslations, $oldExtraTranslation->language_id);
                $problemAndLanguage = [
                    'problem_id' => $problemId,
                    'language_id' => $oldExtraTranslation['language_id'],
                ];
                $this->crowdSourcingProjectProblemTranslationRepository->update(
                    array_merge($problemAndLanguage, [
                        'title' => $newExtraTranslation->title,
                        'description' => $newExtraTranslation->description,
                    ]),
                    $problemAndLanguage,
                    $problemAndLanguage
                );

                // keep track that the translation has already been updated in the DB
                $alreadyUpdatedExtraTranslations[] = $newExtraTranslation;
            } else {
                // else delete the already existing translation from the DB
                $this->crowdSourcingProjectProblemTranslationRepository->deleteTranslation($problemId, $oldExtraTranslation['language_id']);
            }
        }

        // now we need to add the new translations
        foreach ($newExtraTranslations as $newExtraTranslation) {
            // if not already updated, create the record in the DB
            if (!$this->translationExistsInTranslationsArray($newExtraTranslation, $alreadyUpdatedExtraTranslations)) {
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

    /**
     * Check if the translation exists in the translations array.
     */
    protected function translationExistsInTranslationsArray(object $inputTranslation, array $translations): bool {
        foreach ($translations as $translation) {
            if ($translation->language_id === $inputTranslation->language_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the translation from the translations array via the language_id.
     * @throws Exception If the translation with the given language_id is not found in the translations array.
     */
    protected function getTranslationFromTranslationsArrayViaLanguageId(array $translations, int $id): object {
        foreach ($translations as $translation) {
            if ($translation->language_id === $id) {
                return $translation;
            }
        }
        throw new Exception("Translation with language_id: {$id} not found in translations array.");
    }
}
