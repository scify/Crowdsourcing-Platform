<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeQuestionnaireJsonToJsonTypeInQuestionnairesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->json('questionnaire_json')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->longText('questionnaire_json')->change();
        });
    }
}
