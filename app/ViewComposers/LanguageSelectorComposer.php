<?php

namespace App\ViewComposers;

use App\BusinessLogicLayer\LanguageManager;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class LanguageSelectorComposer {

    protected $languageManager;

    public function __construct(LanguageManager $languageManager) {
        $this->languageManager = $languageManager;
    }

    public function compose(View $view) {
        $languages = $this->languageManager->getLanguagesAvailableForPlatformTranslation();
        foreach ($languages as $language) {
            $language->currentRouteLink = route(getNameOfRoute(Route::current()),
                    SetParameterAndGetAll(Route::current(), "locale", $language->language_code)) . getRouteParameters();
        }
        $view->with(['languages' => $languages]);
    }
}
