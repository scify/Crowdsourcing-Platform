<?php

namespace App\Utils;

use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Log;

class Translator {
    public const BATCH_SIZE = 100;

    /**
     * Translate texts to the preferred language.
     *
     * @param  array  $texts The texts that need translation
     * @param  string  $lang_code The language code in which the texts will be translated
     * @return array The translated texts
     *
     * @throws \Exception
     */
    public static function translateTexts(array $texts, string $lang_code): array {
        $translate = new TranslateClient(['key' => config('app.google_translate_key')]);
        // Google translate capacity is 100 texts per request.
        // So we need to break the texts into 100-texts batches
        $batches = array_chunk($texts, self::BATCH_SIZE);
        $result = [];
        foreach ($batches as $batch) {
            try {
                $result = array_merge($result, $translate->translateBatch($batch, [
                    'target' => $lang_code,
                ]));
            } catch (\Exception $e) {
                if (app()->bound('sentry')) {
                    app('sentry')->captureException($e);
                } else {
                    Log::error($e->getMessage());
                }
                throw $e;
            }
        }

        return $result;
    }
}
