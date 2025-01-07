<?php

namespace App\ViewComposers;

use App\BusinessLogicLayer\LanguageManager;
use Illuminate\View\View;

class LanguageSelectorComposer {
    public function __construct(protected LanguageManager $languageManager) {}

    public function compose(View $view): void {
        $languages = $this->languageManager->getLanguagesWithTranslatedResources();
        $view->with(['languages' => $languages]);
    }
}
