<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Questionnaire;

use App\BusinessLogicLayer\LanguageManager;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use Illuminate\Support\Collection;

class QuestionnaireLanguageManager {
    public function __construct(protected QuestionnaireLanguageRepository $questionnaireLanguageRepository, protected LanguageManager $languageManager) {}

    /**
     * Save languages for a questionnaire. If a language is already saved for the questionnaire, it will be updated.
     * If a language is not already saved for the questionnaire, it will be added.
     * If a language is saved for the questionnaire but is not in the list of languages to save, it will be deleted.
     *
     * @param  array  $lang_codes  Array of language codes. Example: ['en', 'de']
     * @param  int  $questionnaire_id  The ID of the questionnaire
     */
    public function saveLanguagesForQuestionnaire(array $lang_codes, int $questionnaire_id): void {
        if ($lang_codes === []) {
            return;
        }

        $existingQuestionnaireLanguages = $this->getLanguagesForQuestionnaire($questionnaire_id);
        $languagesToDelete = $existingQuestionnaireLanguages->pluck('language.language_code')->toArray();
        for ($i = 0; $i < count($lang_codes); ++$i) {
            // fix for Greek language code
            if ($lang_codes[$i] === 'gr') {
                $lang_codes[$i] = 'el';
            }

            if (in_array($lang_codes[$i], $languagesToDelete)) {
                array_splice($languagesToDelete, array_search($lang_codes[$i], $languagesToDelete, true), 1);
            }

            $language = $this->languageManager->getLanguageByCode($lang_codes[$i]);
            if (! $language) {
                continue;
            }

            $data = [
                'questionnaire_id' => $questionnaire_id,
                'language_id' => $language->id,
            ];
            $this->questionnaireLanguageRepository->updateOrCreate($data, $data);
        }

        foreach ($languagesToDelete as $langCode) {
            $language = $this->languageManager->getLanguageByCode($langCode);
            if ($language) {
                $this->questionnaireLanguageRepository->deleteLanguageFromQuestionnaire($language->id, $questionnaire_id);
            }
        }
    }

    public function getLanguagesForQuestionnaire(int $questionnaire_id): Collection {
        return $this->questionnaireLanguageRepository->getLanguagesForQuestionnaire($questionnaire_id);
    }
}
