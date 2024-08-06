<?php

namespace Database\Seeders;

use App\Repository\LanguageRepository;
use Illuminate\Database\Seeder;

class LanguagesLkpTableSeeder extends Seeder {
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
        // languages found here: https://en.wikipedia.org/wiki/Languages_of_the_European_Union
        $languages = [
            [
                'code' => 'bg',
                'name' => 'Bulgarian',
                'default_color' => '#81c784',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'hr',
                'name' => 'Croatian',
                'default_color' => '#90caf9',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'cs',
                'name' => 'Czech',
                'default_color' => '#d32f2f',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'da',
                'name' => 'Danish',
                'default_color' => '#d50000',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'nl',
                'name' => 'Dutch',
                'default_color' => '#5c6bc0',
                'available_for_platform_translation' => true,
            ], [
                'code' => 'en',
                'name' => 'English',
                'default_color' => '#ffcdd2',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'et',
                'name' => 'Estonian',
                'default_color' => '#2962ff',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'fi',
                'name' => 'Finnish',
                'default_color' => '#29b6f6',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'ga',
                'name' => 'Irish',
                'default_color' => '#66bb6a',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'fr',
                'name' => 'French',
                'default_color' => '#1565c0',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'de',
                'name' => 'German',
                'default_color' => '#f4511e',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'el',
                'name' => 'Greek',
                'default_color' => '#1e88e5',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'hu',
                'name' => 'Hungarian',
                'default_color' => '#1b5e20',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'it',
                'name' => 'Italian',
                'default_color' => '#3949ab',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'lv',
                'name' => 'Latvian',
                'default_color' => '#8e24aa',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'lt',
                'name' => 'Lithuanian',
                'default_color' => '#43a047',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'pl',
                'name' => 'Polish',
                'default_color' => '#e57373',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'pt',
                'name' => 'Portuguese',
                'default_color' => '#ef5350',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'ro',
                'name' => 'Romanian',
                'default_color' => '#ffb300',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'sk',
                'name' => 'Slovak',
                'default_color' => '#0d47a1',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'sl',
                'name' => 'Slovenian',
                'default_color' => '#d81b60',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'es',
                'name' => 'Spanish',
                'default_color' => '#fb8c00',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'sv',
                'name' => 'Swedish',
                'default_color' => '#fdd835',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'mt',
                'name' => 'Maltese',
                'default_color' => '#b71c1c',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'sq',
                'name' => 'Albanian',
                'default_color' => '#e53935',
                'available_for_platform_translation' => false,
            ],
            [
                'code' => 'sr',
                'name' => 'Montenegrin',
                'default_color' => '#06004D',
                'available_for_platform_translation' => true,
            ],
            [
                'code' => 'tr',
                'name' => 'Turkish',
                'default_color' => '#e53935',
                'available_for_platform_translation' => false,
            ],
        ];
        foreach ($languages as $languageObj) {
            $this->languagesRepository->updateOrCreate(['language_code' => $languageObj['code']],
                [
                    'language_code' => $languageObj['code'],
                    'language_name' => $languageObj['name'],
                    'default_color' => $languageObj['default_color'],
                    'available_for_platform_translation' => $languageObj['available_for_platform_translation'],
                ]
            );
        }
    }
}
