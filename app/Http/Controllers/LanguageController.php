<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\LanguageManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller {
    protected LanguageManager $languageManager;

    public function __construct(LanguageManager $languageManager) {
        $this->languageManager = $languageManager;
    }

    public function getLanguages(): JsonResponse {
        return response()->json([
            'languages' => $this->languageManager->getLanguagesAvailableForPlatformTranslation(),
        ]);
    }

    public function setLocale(Request $request): RedirectResponse {
        // validate the locale:
        // it should exist in the languages table
        $this->validate($request, [
            'locale' => 'required|exists:languages_lkp,language_code',
        ]);
        $locale = $request->input('locale');
        // Due to the SetLocale middleware, the locale will be automatically set
        // we just need to replace the locale in the URL, redirect back, and the middleware will do the rest.
        // replace the locale in the URL:
        // get the previous URL:
        $url = url()->previous();
        // replace the locale in the URL. The URL is always in the format: http://domain/{locale}/...
        $url = preg_replace('/\/[a-z]{2}\//', "/$locale/", $url);
        // redirect to the new URL:
        return redirect($url);
    }
}
