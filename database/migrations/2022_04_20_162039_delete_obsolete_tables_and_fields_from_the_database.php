<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteObsoleteTablesAndFieldsFromTheDatabase extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::dropIfExists('questionnaire_translation_html');
        Schema::dropIfExists('questionnaire_html');
        Schema::dropIfExists('questionnaire_response_answer_texts');
        Schema::dropIfExists('questionnaire_translation_possible_answers');
        Schema::dropIfExists('questionnaire_translation_questions');
        Schema::dropIfExists('questionnaire_response_answers');
        Schema::dropIfExists('questionnaire_possible_answers');
        Schema::dropIfExists('questionnaire_questions');
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}
