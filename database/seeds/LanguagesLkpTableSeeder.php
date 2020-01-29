<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesLkpTableSeeder extends Seeder
{
    // languages found here: https://en.wikipedia.org/wiki/Languages_of_the_European_Union
    private static $LANGUAGES = [
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
        'mt' => 'Maltese'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [];
        $idToInsert = 1;
        foreach(self::$LANGUAGES as $code => $name) {
            array_push($languages, [
                'id' => $idToInsert,
                'language_code' => $code,
                'language_name' => $name,
            ]);
            $idToInsert++;
        }
        DB::table('languages_lkp')->delete();
        DB::table('languages_lkp')->insert($languages);
    }
}
