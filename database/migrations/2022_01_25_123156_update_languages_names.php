<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateLanguagesNames extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement("update languages_lkp set language_name = 'German (Deutsch)' where  language_code = 'de'");
        DB::statement("update languages_lkp set language_name = 'Nederlands' where  language_code = 'nl'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
