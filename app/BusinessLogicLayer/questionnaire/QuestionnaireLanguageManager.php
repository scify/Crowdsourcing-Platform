<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\LanguageManager;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use Illuminate\Support\Collection;

class QuestionnaireLanguageManager {

    protected $questionnaireLanguageRepository;
    protected $languageManager;

    public function __construct(QuestionnaireLanguageRepository $questionnaireLanguageRepository,
                                LanguageManager $languageManager) {
        $this->questionnaireLanguageRepository = $questionnaireLanguageRepository;
        $this->languageManager = $languageManager;
    }

    public function saveLanguagesForQuestionnaire(array $lang_codes, int $questionnaire_id) {
        if(count($lang_codes) === 0)
            return;
        $existingQuestionnaireLanguages = $this->getLanguagesForQuestionnaire($questionnaire_id);
        $languagesToDelete = $existingQuestionnaireLanguages->pluck('language.language_code')->toArray();
        for ($i = 0; $i < count($lang_codes); $i++) {
            if (in_array($lang_codes[$i], $languagesToDelete))
                array_splice($languagesToDelete, array_search($lang_codes[$i], $languagesToDelete), 1);

            $language = $this->languageManager->getLanguageByCode($lang_codes[$i]);
            $data = [
                'questionnaire_id' => $questionnaire_id,
                'language_id' => $language->id
            ];
            $this->questionnaireLanguageRepository->updateOrCreate($data, $data);
        }
        foreach ($languagesToDelete as $langCode) {
            $language = $this->languageManager->getLanguageByCode($langCode);
            $this->questionnaireLanguageRepository->deleteLanguageByForQuestionnaire($language->id, $questionnaire_id);
        }
    }

    public function getLanguagesForQuestionnaire(int $questionnaire_id): Collection {
        return $this->questionnaireLanguageRepository->getLanguagesForQuestionnaire($questionnaire_id);
    }
}
