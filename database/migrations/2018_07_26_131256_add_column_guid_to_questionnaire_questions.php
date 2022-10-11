<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGuidToQuestionnaireQuestions extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaire_questions', function (Blueprint $table) {
            $table->string('guid', 40)->default(1)->after('questionnaire_id');
            $table->index('guid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaire_questions', function (Blueprint $table) {
            //
        });
    }
}
