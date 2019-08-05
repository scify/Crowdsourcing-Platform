<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 6/6/18
 * Time: 4:52 PM
 */

namespace App\Utils;

use Google\Cloud\Translate\TranslateClient;

class Translator
{
    /**
     * Translate texts to the preferred language.
     * @param array $texts   The texts that need translation
     * @param string $to     The language in which the texts will be translated
     * @return array         The translated texts
     */
    public static function translateTexts(array $texts, $to)
    {
        $translate = new TranslateClient(['key' => config('app.google_translate_key')]);
        $result = $translate->translateBatch($texts, [
            'target' => $to,
        ]);
        return $result;
    }
}
