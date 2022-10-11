<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageIdToQuestionnaireResponsesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaire_responses', function (Blueprint $table) {
            $table->unsignedInteger('language_id')->after('user_id')->nullable();
            $table->foreign('language_id')->references('id')->on('languages_lkp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaire_responses', function (Blueprint $table) {
            $table->dropForeign('questionnaire_responses_language_id_foreign');
            $table->dropColumn('language_id');
        });
    }
}
