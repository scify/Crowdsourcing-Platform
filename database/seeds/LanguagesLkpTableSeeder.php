<?php

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
                'default_color' => '#90caf9'
            ],
            [
                'code' => 'cs',
                'name' => 'Czech',
                'default_color' => '#d32f2f'
            ],
            [
                'code' => 'da',
                'name' => 'Danish',
                'default_color' => '#d50000'
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
                'default_color' => '#29b6f6'
            ],
            [
                'code' => 'ga',
                'name' => 'Irish',
                'default_color' => '#66bb6a'
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
                'default_color' => '#3949ab'
            ],
            [
                'code' => 'lv',
                'name' => 'Latvian',
                'default_color' => '#8e24aa'
            ],
            [
                'code' => 'lt',
                'name' => 'Lithuanian',
                'default_color' => '#43a047'
            ],
            [
                'code' => 'pl',
                'name' => 'Polish',
                'default_color' => '#e57373'
            ],
            [
                'code' => 'pt',
                'name' => 'Portuguese',
                'default_color' => ''
            ],
            [
                'code' => 'ro',
                'name' => 'Romanian',
                'default_color' => '#ffb300'
            ],
            [
                'code' => 'sk',
                'name' => 'Slovak',
                'default_color' => '#0d47a1'
            ],
            [
                'code' => 'sl',
                'name' => 'Slovenian',
                'default_color' => '#d81b60'
            ],
            [
                'code' => 'es',
                'name' => 'Spanish',
                'default_color' => '#fb8c00'
            ],
            [
                'code' => 'sv',
                'name' => 'Swedish',
                'default_color' => '#fdd835'
            ],
            [
                'code' => 'mt',
                'name' => 'Maltese',
                'default_color' => '#b71c1c'
            ],
            [
                'code' => 'sq',
                'name' => 'Albanian',
                'default_color' => '#e53935'
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
        }
    }
}
