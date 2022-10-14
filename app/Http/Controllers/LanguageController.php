<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\LanguageManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller {
    protected $languageManager;

    public function __construct(LanguageManager $languageManager) {
        $this->languageManager = $languageManager;
    }

    public function getLanguages(): JsonResponse {
        return response()->json([
            'languages' => $this->languageManager->getLanguagesAvailableForPlatformTranslation(),
        ]);
    }

    public function getAppTranslations(): JsonResponse {
        $currentLocale = app()->getLocale();
        $langPath = base_path('lang/' . $currentLocale);
        $translations = Cache::rememberForever('translations_' . $currentLocale, function () use ($langPath) {
            return collect(File::allFiles($langPath))->flatMap(function ($file) {
                return [
                    $translation = $file->getBasename('.php') => trans($translation),
                ];
            })->toJson();
        });
        return response()->json([
            'translations' => json_decode($translations),
        ]);
    }
}
