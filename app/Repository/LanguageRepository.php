<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Language;

class LanguageRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function getModelClassName(): string {
        return Language::class;
    }

    public function getLanguageByCode(string $code): Language {
        return Language::where('language_code', $code)->first();
    }

    public function getDefaultLanguage(): Language {
        // english is the default language
        return Language::findOrFail(6);
    }
}
