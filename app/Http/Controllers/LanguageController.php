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
        // get everything after the last slash:
        $restOfUrl = substr($url, strrpos($url, '/') + 1);
        // get the domain name with the protocol:
        $domain = $request->getSchemeAndHttpHost();
        // replace the locale in the URL:
        $url = $domain . '/' . $locale . '/' . $restOfUrl;
        // redirect to the new URL:
        return redirect($url);
    }
}
