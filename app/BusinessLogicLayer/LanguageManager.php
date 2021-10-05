<?php

namespace App\BusinessLogicLayer;


use App\Repository\LanguageRepository;
use Illuminate\Database\Eloquent\Collection;

class LanguageManager {
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository) {
        $this->languageRepository = $languageRepository;
    }

    public function getAllLanguages(): Collection {
        return $this->languageRepository->all();
    }

    public function getLanguage($id) {
        return $this->languageRepository->find($id);
    }

    public function getLanguageByCode($languageCode) {
        return $this->languageRepository->where([
            'language_code' => $languageCode
        ]);
    }
}
