<?php

namespace App\BusinessLogicLayer;

use App\Repository\LanguageRepository;
use App\Utils\Translator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class LanguageManager {
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository) {
        $this->languageRepository = $languageRepository;
    }

    public function getAllLanguages(): Collection {
        return Cache::rememberForever('languages', function () {
            return $this->languageRepository->all(['*'], 'language_name');
        });
    }

    public function getLanguagesAvailableForPlatformTranslation(): Collection {
        return Cache::rememberForever('languages_platform_translation', function () {
            return $this->languageRepository->allWhere(['available_for_platform_translation' => true], ['*'], 'language_name');
        });
    }

    public function getLanguage($id) {
        return $this->languageRepository->find($id);
    }

    public function getLanguageByCode($languageCode) {
        return $this->getAllLanguages()->firstWhere('language_code', '=', $languageCode);
    }

    public function getLanguageById($languageId) {
        return $this->getAllLanguages()->firstWhere('id', '=', $languageId);
    }

    /**
     * @throws \Exception
     */
    public function getTranslationForTexts(array $texts, array $target_lang_codes): array {
        $translated_texts = [];
        foreach ($target_lang_codes as $target_lang_code) {
            $translated_texts[] = Translator::translateTexts($texts, $target_lang_code);
        }

        return $translated_texts;
    }
}
