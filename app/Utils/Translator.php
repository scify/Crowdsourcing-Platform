<?php

namespace App\Utils;

use Google\Cloud\Translate\V2\TranslateClient;

class Translator
{
    public const BATCH_SIZE = 100;
    /**
     * Translate texts to the preferred language.
     * @param array $texts   The texts that need translation
     * @param string $to     The language in which the texts will be translated
     * @return array         The translated texts
     */
    public static function translateTexts(array $texts, $to)
    {
        $translate = new TranslateClient(['key' => config('app.google_translate_key')]);
        // Google translate capacity is 100 texts per request.
        // So we need to break the texts into 100-texts batches
        $batches = array_chunk($texts, self::BATCH_SIZE);
        $result = [];
        foreach ($batches as $batch) {
            array_merge($result, $translate->translateBatch($batch, [
                'target' => $to,
            ]));
        }
        return $result;
    }
}
