<?php

namespace Database\Seeders;

use App\Repository\LanguageRepository;
use Illuminate\Database\Seeder;

class LanguagesRussianMontenegrinSeeder extends Seeder
{
    protected $languagesRepository;

    public function __construct(LanguageRepository $languagesRepository) {
        $this->languagesRepository = $languagesRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $languages = [
            [
                'code' => 'mg',
                'name' => 'Montenegrin',
                'default_color' => '#06004D'
            ],
            [
                'code' => 'ru',
                'name' => 'Russian',
                'default_color' => '#06004D'
            ],
           ];
        foreach ($languages as $languageObj) {
            $this->languagesRepository->updateOrCreate(['language_code' => $languageObj['code']],
                [
                    'language_code' => $languageObj['code'],
                    'language_name' => $languageObj['name'],
                    'default_color' => $languageObj['default_color']
                ]
            );
        }
    }
}
