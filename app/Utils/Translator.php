<?php

namespace App\Utils;

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Support\Facades\Log;

class Translator {
    public const BATCH_SIZE = 100;

    /**
     * Translate texts to the preferred language.
     *
     * @param  array  $texts The texts that need translation. This array should contain elements of type string.
     *                            Example: ['Hello', 'Goodbye']
     * @param  string  $target_lang_code The target language code in which the texts will be translated
     * @return array The translated texts
     *
     * @throws \Exception
     */
    public static function translateTexts(array $texts, string $target_lang_code): array {
        // fix for Greek language code
        if ($target_lang_code === 'gr') {
            $target_lang_code = 'el';
        }

        $translate = new TranslateClient(['key' => config('app.google_translate_key')]);
        // Google translate capacity is 100 texts per request.
        // So we need to break the texts into 100-texts batches
        $batches = array_chunk($texts, self::BATCH_SIZE);
        $result = [];
        foreach ($batches as $batch) {
            try {
                $result = array_merge($result, $translate->translateBatch($batch, [
                    'target' => $target_lang_code,
                ]));
            } catch (\Exception $e) {
                $error_message_from_service = json_decode($e->getMessage(), true);
                $error_message = 'Error translating texts: ' . $error_message_from_service['error']['message'];
                if (app()->bound('sentry')) {
                    app('sentry')->captureException($e);
                } else {
                    Log::error($e->getMessage());
                }
                throw new ServiceException($error_message);
            }
        }

        return $result;
    }
}
