<?php

namespace App\Repository;

use App\Models\Language;

class LanguageRepository extends Repository {
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModelClassName() {
        return Language::class;
    }

    public function getLanguageByCode(string $code): Language {
        return Language::where('language_code', $code)->first();
    }
}
