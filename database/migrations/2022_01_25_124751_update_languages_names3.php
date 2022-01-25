<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateLanguagesNames3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("update languages_lkp set language_name = 'Bulgarian (български)' where language_code = 'bg'");
        DB::statement("update languages_lkp set language_name = 'Croatian (Hrvatski)' where language_code = 'hr'");
        DB::statement("update languages_lkp set language_name = 'Czech (čeština)' where language_code = 'cs'");
        DB::statement("update languages_lkp set language_name = 'Danish (dansk)' where language_code = 'da'");
        DB::statement("update languages_lkp set language_name = 'Estonian (eesti keel) ' where language_code = 'et'");
        DB::statement("update languages_lkp set language_name = 'Finnish (suomi)' where language_code = 'fi'");
        DB::statement("update languages_lkp set language_name = 'French (Français)' where language_code = 'fr'");
        DB::statement("update languages_lkp set language_name = 'Greek (Ελληνικά)' where language_code = 'el'");
        DB::statement("update languages_lkp set language_name = 'Hungarian (magyar nyelv)' where language_code = 'hu'");
        DB::statement("update languages_lkp set language_name = 'Irish (Gaeilge)' where language_code = 'ga'");
        DB::statement("update languages_lkp set language_name = 'Italian' where language_code = 'it'");
        DB::statement("update languages_lkp set language_name = 'Lithuanian (lietuvių kalba)' where language_code = 'lt'");
        DB::statement("update languages_lkp set language_name = 'Polish (Polskie)' where language_code = 'pl'");
        DB::statement("update languages_lkp set language_name = 'Portuguese (Português)' where language_code = 'pt'");
        DB::statement("update languages_lkp set language_name = 'Romanian (Română)' where language_code = 'ro'");
        DB::statement("update languages_lkp set language_name = 'Slovak (slovenský)' where language_code = 'sk'");
        DB::statement("update languages_lkp set language_name = 'Slovenian (Slovenščina)' where language_code = 'sl'");
        DB::statement("update languages_lkp set language_name = 'Spanish (Español()' where language_code = 'es'");
        DB::statement("update languages_lkp set language_name = 'Swedish (svenska)' where language_code = 'sv'");
        DB::statement("update languages_lkp set language_name = 'Maltese (Malti)' where language_code = 'mt'");
        DB::statement("update languages_lkp set language_name = 'Albanian (shqiptare)' where language_code = 'sq'");
        DB::statement("update languages_lkp set language_name = 'Turkish (Türkçe)' where language_code = 'tr'");
        DB::statement("update languages_lkp set language_name = 'Montenegrin' where language_code = 'sr'");
        DB::statement("update languages_lkp set language_name = 'Russian (русский)' where language_code = 'ru'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
