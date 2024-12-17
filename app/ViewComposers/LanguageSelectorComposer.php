<?php

namespace App\ViewComposers;

use App\BusinessLogicLayer\LanguageManager;
use Illuminate\View\View;

class LanguageSelectorComposer {
    protected LanguageManager $languageManager;

    public function __construct(LanguageManager $languageManager) {
        $this->languageManager = $languageManager;
    }

    public function compose(View $view) {
        $languages = $this->languageManager->getLanguagesWithTranslatedResources();
        $view->with(['languages' => $languages]);
    }
}
