<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\LanguageManager;
use Illuminate\Http\JsonResponse;

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
}
