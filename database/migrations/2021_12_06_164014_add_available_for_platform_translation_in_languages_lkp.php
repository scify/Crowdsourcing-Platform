<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailableForPlatformTranslationInLanguagesLkp extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('languages_lkp', function (Blueprint $table) {
            $table->boolean('available_for_platform_translation')->default(true)->after('language_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('languages_lkp', function (Blueprint $table) {
            $table->dropColumn('available_for_platform_translation');
        });
    }
}
