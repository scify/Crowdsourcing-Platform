<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorQuestionnaireResponseAnswerTextsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->unsignedInteger('questionnaire_id')->nullable()->after('id');
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->string('question_name')->nullable()->after('questionnaire_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->dropForeign('questionnaire_response_answer_texts_questionnaire_id_foreign');
            $table->dropColumn('questionnaire_id');
            $table->dropColumn('question_name');
        });
    }
}
