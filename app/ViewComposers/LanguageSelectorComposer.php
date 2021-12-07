<?php

namespace App\ViewComposers;

use App\BusinessLogicLayer\LanguageManager;
use Illuminate\View\View;

class LanguageSelectorComposer {

    protected $languageManager;

    public function __construct(LanguageManager $languageManager) {
        $this->languageManager = $languageManager;
    }

    public function compose(View $view) {
        $view->with(['languages' => $this->languageManager->getLanguagesAvailableForPlatformTranslation()]);
    }
}
