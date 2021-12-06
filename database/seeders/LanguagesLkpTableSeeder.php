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
                'default_color' => '#81c784'
            ],
            [
                'code' => 'hr',
                'name' => 'Croatian',
                'default_color' => '#90caf9',
                'delete' => true
            ],
            [
                'code' => 'cs',
                'name' => 'Czech',
                'default_color' => '#d32f2f',
                'delete' => true
            ],
            [
                'code' => 'da',
                'name' => 'Danish',
                'default_color' => '#d50000',
                'delete' => true
            ],
            [
                'code' => 'nl',
                'name' => 'Dutch',
                'default_color' => '#5c6bc0'
            ], [
                'code' => 'en',
                'name' => 'English',
                'default_color' => '#ffcdd2'
            ],
            [
                'code' => 'et',
                'name' => 'Estonian',
                'default_color' => '#2962ff'
            ],
            [
                'code' => 'fi',
                'name' => 'Finnish',
                'default_color' => '#29b6f6',
                'delete' => true
            ],
            [
                'code' => 'ga',
                'name' => 'Irish',
                'default_color' => '#66bb6a',
                'delete' => true
            ],
            [
                'code' => 'fr',
                'name' => 'French',
                'default_color' => '#1565c0'
            ],
            [
                'code' => 'de',
                'name' => 'German',
                'default_color' => '#f4511e'
            ],
            [
                'code' => 'el',
                'name' => 'Greek',
                'default_color' => '#1e88e5'
            ],
            [
                'code' => 'hu',
                'name' => 'Hungarian',
                'default_color' => '#1b5e20'
            ],
            [
                'code' => 'it',
                'name' => 'Italian',
                'default_color' => '#3949ab',
                'delete' => true
            ],
            [
                'code' => 'lv',
                'name' => 'Latvian',
                'default_color' => '#8e24aa'
            ],
            [
                'code' => 'lt',
                'name' => 'Lithuanian',
                'default_color' => '#43a047',
                'delete' => true
            ],
            [
                'code' => 'pl',
                'name' => 'Polish',
                'default_color' => '#e57373',
                'delete' => true
            ],
            [
                'code' => 'pt',
                'name' => 'Portuguese',
                'default_color' => '#ef5350'
            ],
            [
                'code' => 'ro',
                'name' => 'Romanian',
                'default_color' => '#ffb300',
                'delete' => true
            ],
            [
                'code' => 'sk',
                'name' => 'Slovak',
                'default_color' => '#0d47a1',
                'delete' => true
            ],
            [
                'code' => 'sl',
                'name' => 'Slovenian',
                'default_color' => '#d81b60',
                'delete' => true
            ],
            [
                'code' => 'es',
                'name' => 'Spanish',
                'default_color' => '#fb8c00',
                'delete' => true
            ],
            [
                'code' => 'sv',
                'name' => 'Swedish',
                'default_color' => '#fdd835',
                'delete' => true
            ],
            [
                'code' => 'mt',
                'name' => 'Maltese',
                'default_color' => '#b71c1c',
                'delete' => true
            ],
            [
                'code' => 'sq',
                'name' => 'Albanian',
                'default_color' => '#e53935',
                'delete' => true
            ],
            [
                'code' => 'mg',
                'name' => 'Montenegrin',
                'default_color' => '#06004D'
            ],
            [
                'code' => 'ru',
                'name' => 'Russian',
                'default_color' => '#06004D'
            ]
        ];
        foreach ($languages as $languageObj) {
            $this->languagesRepository->updateOrCreate(['language_code' => $languageObj['code']],
                [
                    'language_code' => $languageObj['code'],
                    'language_name' => $languageObj['name'],
                    'default_color' => $languageObj['default_color']
                ]
            );
            if (isset($languageObj['delete']) && $languageObj['delete']) {
                $this->languagesRepository->delete($this->languagesRepository->where(['language_code' => $languageObj['code']])->id);
                echo "\nDeleted: " . $languageObj['name'] . " (" . $languageObj['code'] . ").\n";
            }
        }
    }
}
