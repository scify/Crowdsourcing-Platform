<?php

namespace App\BusinessLogicLayer\Problem;

use App\Models\Problem\Problem;
use App\Repository\LanguageRepository;
use App\Repository\Problem\ProblemRepository;
use App\Repository\Problem\ProblemTranslationRepository;
use App\Repository\RepositoryException;
use Exception;
use Illuminate\Support\Collection;

class ProblemTranslationManager {
    protected ProblemTranslationRepository $problemTranslationRepository;
    protected LanguageRepository $languageRepository;
    protected ProblemRepository $problemRepository;

    public function __construct(
        ProblemTranslationRepository $problemTranslationRepository,
        LanguageRepository $languageRepository,
        ProblemRepository $problemRepository
    ) {
        $this->problemTranslationRepository = $problemTranslationRepository;
        $this->languageRepository = $languageRepository;
        $this->problemRepository = $problemRepository;
    }

    /**
     * Get all the translations for a problem.
     *
     * This function accepts either an integer ID or an instance of the
     * CrowdSourcingProjectProblem class and returns a Collection object
     * with all of the problems defined translations.
     *
     * @param int|Problem $input An integer ID or a CrowdSourcingProjectProblem object.
     */
    public function getTranslationsForProblem(int|Problem $input): Collection {
        if (gettype($input) !== 'integer') {
            $id = $input->id;
        } else {
            $id = $input;
        }

        if (!$id) {
            return new Collection;
        }

        return $this->problemTranslationRepository->allWhere(['problem_id' => $id]);
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
        $this->problemTranslationRepository->updateOrCreate(
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
        $problemDefaultTranslationId = $this->problemRepository->find($problemId)->default_language_id;
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
                $this->problemTranslationRepository->update(
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
                $this->problemTranslationRepository->deleteTranslation($problemId, $oldExtraTranslation['language_id']);
            }
        }

        // now we need to add the new translations
        foreach ($newExtraTranslations as $newExtraTranslation) {
            // if not already updated, create the record in the DB
            if (!$this->translationExistsInTranslationsArray($newExtraTranslation, $alreadyUpdatedExtraTranslations)) {
                $this->problemTranslationRepository->create(
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

    /**
     * Get the current translation for a problem.
     * If the translation for the given language does not exist, the default translation is returned.
     *
     * @param int $problem_id the ID of the problem
     * @param string $language_code the language code of the translation
     * @return object the current translation for the problem
     */
    public function getProblemCurrentTranslation(int $problem_id, string $language_code): object {
        $languageId = $this->languageRepository->getLanguageByCode($language_code)->id;
        $problemTranslations = $this->getTranslationsForProblem($problem_id);
        $currentTranslation = $problemTranslations->firstWhere('language_id', $languageId);

        return $currentTranslation ?? $problemTranslations->firstWhere('language_id', $this->problemRepository->find($problem_id)->default_language_id);
    }
}
