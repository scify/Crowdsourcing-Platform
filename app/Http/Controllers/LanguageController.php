<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\LanguageManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller {
    public function __construct(protected LanguageManager $languageManager) {}

    public function getLanguages(): JsonResponse {
        return response()->json([
            'languages' => $this->languageManager->getLanguagesAvailableForPlatformTranslation(),
        ]);
    }

    public function setLocale(Request $request): RedirectResponse {
        // Validate the locale: it should exist in the languages table
        $this->validate($request, [
            'locale' => 'required|exists:languages_lkp,language_code',
        ]);

        $locale = $request->input('locale');
        // Due to the SetLocale middleware, the locale will be automatically set
        // we just need to replace the locale in the URL, redirect back, and the middleware will do the rest.
        // replace the locale in the URL:
        // get the previous URL:
        $url = url()->previous();

        // Replace the existing locale in the URL with the new one
        $url = preg_replace('/\/[a-z]{2}(\/|$)/', '/' . $locale . '$1', $url, 1);

        // If no locale was found and replaced, append it after the base URL
        if (in_array(preg_match('/\/[a-z]{2}(\/|$)/', url()->previous()), [0, false], true)) {
            $url = rtrim(url('/'), '/') . '/' . $locale;
        }

        // Redirect to the new URL
        return redirect($url);
    }

    public function getAutomaticTranslationForTexts(Request $request): JsonResponse {
        $this->validate($request, [
            'texts' => 'required|array',
            'target_lang_code' => 'required|string|exists:languages_lkp,language_code',
        ]);
        $target_lang_code = $request->input('target_lang_code');
        $texts = $request->input('texts');
        $translated_texts = $this->languageManager->getAutomaticTranslationForTexts($texts, $target_lang_code);

        return response()->json([
            'translated_texts' => $translated_texts,
        ]);
    }
}
