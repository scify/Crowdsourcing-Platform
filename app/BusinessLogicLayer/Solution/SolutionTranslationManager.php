<?php

namespace App\BusinessLogicLayer\Solution;

use App\Models\Solution\Solution;
use App\Repository\Solution\SolutionRepository;
use App\Repository\Solution\SolutionTranslationRepository;
use Exception;
use Illuminate\Support\Collection;

class SolutionTranslationManager {
    protected SolutionTranslationRepository $solutionTranslationRepository;
    protected SolutionRepository $solutionRepository;

    public function __construct(
        SolutionTranslationRepository $solutionTranslationRepository,
        SolutionRepository $solutionRepository,
    ) {
        $this->solutionTranslationRepository = $solutionTranslationRepository;
        $this->solutionRepository = $solutionRepository;
    }

    /**
     * Get all the translations for a solution.
     *
     * This function accepts either an integer ID or an instance of the
     * Solution class and returns a Collection object
     * with all of the solution's defined translations.
     *
     * @param int|Solution $input An integer ID or a Solution object.
     */
    public function getTranslationsForSolution(int|Solution $input): Collection {
        if (gettype($input) !== 'integer') {
            $id = $input->id;
        } else {
            $id = $input;
        }

        if (!$id) {
            return new Collection;
        }

        return $this->solutionTranslationRepository->allWhere(['solution_id' => $id]);
    }

    /**
     * @throws RepositoryException
     */
    public function updateSolutionTranslations(int $solutionId, array $defaultTranslation, array $extraTranslations): void {
        $this->updateSolutionDefaultTranslation($solutionId, $defaultTranslation);

        $this->updateSolutionExtraTranslations($solutionId, $extraTranslations);
    }

    /**
     * Updates the default translation for a solution.
     */
    protected function updateSolutionDefaultTranslation(int $solutionId, array $defaultTranslation): void {
        $this->solutionTranslationRepository->updateOrCreate(
            [
                'solution_id' => $solutionId,
                'language_id' => $defaultTranslation['language_id'],
            ],
            [
                'title' => $defaultTranslation['title'],
                'description' => $defaultTranslation['description'],
            ]
        );
    }

    /**
     * Updates the extra translations for a solution.
     *
     * @throws \App\Repository\RepositoryException
     */
    protected function updateSolutionExtraTranslations(int $solutionId, array $newExtraTranslations): void {
        $solutionDefaultTranslationId = $this->solutionRepository->find($solutionId)->default_language_id;
        $oldExtraTranslations = $this->getTranslationsForSolution($solutionId)->whereNotIn('language_id', $solutionDefaultTranslationId);
        $alreadyUpdatedExtraTranslations = [];

        // for each of the already existing translations
        foreach ($oldExtraTranslations as $oldExtraTranslation) {
            // if there is a new translation, update the already existing translation in DB
            if ($this->translationExistsInTranslationsArray($oldExtraTranslation, $newExtraTranslations)) {
                $newExtraTranslation = $this->getTranslationFromTranslationsArrayViaLanguageId($newExtraTranslations, $oldExtraTranslation->language_id);
                $solutionAndLanguage = [
                    'solution_id' => $solutionId,
                    'language_id' => $oldExtraTranslation['language_id'],
                ];
                $this->solutionTranslationRepository->update(
                    array_merge($solutionAndLanguage, [
                        'title' => $newExtraTranslation->title,
                        'description' => $newExtraTranslation->description,
                    ]),
                    $solutionAndLanguage,
                    $solutionAndLanguage
                );

                // keep track that the translation has already been updated in the DB
                $alreadyUpdatedExtraTranslations[] = $newExtraTranslation;
            } else {
                // else delete the already existing translation from the DB
                $this->solutionTranslationRepository->deleteTranslation($solutionId, $oldExtraTranslation['language_id']);
            }
        }

        // now we need to add the new translations
        foreach ($newExtraTranslations as $newExtraTranslation) {
            // if not already updated, create the record in the DB
            if (!$this->translationExistsInTranslationsArray($newExtraTranslation, $alreadyUpdatedExtraTranslations)) {
                $this->solutionTranslationRepository->create(
                    [
                        'solution_id' => $solutionId,
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
