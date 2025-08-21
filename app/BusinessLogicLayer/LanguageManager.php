<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer;

use App\Repository\LanguageRepository;
use App\Utils\Translator;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class LanguageManager {
    public function __construct(private readonly LanguageRepository $languageRepository) {}

    public function getAllLanguages(): Collection {
        return Cache::rememberForever('languages', fn () => $this->languageRepository->all(['*'], 'language_name'));
    }

    public function getLanguagesAvailableForPlatformTranslation(): Collection {
        return Cache::rememberForever('languages_platform_translation', fn () => $this->languageRepository->allWhere(['available_for_platform_translation' => true], ['*'], 'language_name'));
    }

    public function getLanguage($id) {
        return $this->languageRepository->find($id);
    }

    public function getLanguageByCode($languageCode) {
        return $this->languageRepository->where(['language_code' => $languageCode]);
    }

    public function getLanguageById($languageId) {
        return $this->languageRepository->find($languageId);
    }

    /**
     * Translate texts to the preferred language.
     *
     * @param  array  $texts  The texts that need translation. This array should contain elements of type:
     *                        { id: string, original_text: string }
     * @param  string  $target_lang_code  The target language code in which the texts will be translated. Example: 'en'
     *
     * @return array The translated texts
     *
     * @throws Exception
     */
    public function getAutomaticTranslationForTexts(array $texts, string $target_lang_code): array {
        // extract the original texts from the input array
        $original_texts = array_map(fn (array $text) => $text['original_text'], $texts);
        $translated_texts = Translator::translateTexts($original_texts, $target_lang_code);
        // combine the original texts with the translated texts
        $result = [];
        foreach ($texts as $index => $text) {
            $result[] = [
                'id' => $text['id'],
                'original_text' => $text['original_text'],
                'translated_text' => $translated_texts[$index]['text'],
            ];
        }

        return $result;
    }

    public function getLanguagesWithTranslatedResources() {
        return Cache::rememberForever('languages_resources_translated', fn () => $this->languageRepository->allWhere(['resources_translated' => true], ['*'], 'language_code'));
    }
}
