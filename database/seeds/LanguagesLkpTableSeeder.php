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
            'bg' => 'Bulgarian',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'en' => 'English',
            'et' => 'Estonian',
            'fi' => 'Finnish',
            'fr' => 'French',
            'de' => 'German',
            'el' => 'Greek',
            'hu' => 'Hungarian',
            'ga' => 'Irish',
            'it' => 'Italian',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'ro' => 'Romanian',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'es' => 'Spanish',
            'sv' => 'Swedish',
            'mt' => 'Maltese',
            'sq' => 'Albanian'
        ];
        $idToInsert = 1;
        foreach ($languages as $code => $name) {
            $this->languagesRepository->updateOrCreate(['id' => $idToInsert],
                [
                    'id' => $idToInsert,
                    'language_code' => $code,
                    'language_name' => $name,
                ]
            );
            $idToInsert++;
        }
    }
}
