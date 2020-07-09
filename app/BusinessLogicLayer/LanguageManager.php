<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/5/18
 * Time: 3:50 PM
 */

namespace App\BusinessLogicLayer;


use App\Repository\LanguageRepository;

class LanguageManager
{
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function getAllLanguages()
    {
        return $this->languageRepository->all();
    }

    public function getLanguage($id) {
        return $this->languageRepository->find($id);
    }

    public function getLanguageByCode($languageCode) {
        return $this->languageRepository->where([
            'language_code' => $languageCode
        ])->first();
    }
}
