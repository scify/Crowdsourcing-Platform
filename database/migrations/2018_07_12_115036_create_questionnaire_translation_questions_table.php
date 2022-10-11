<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireTranslationQuestionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_translation_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_language_id');
            $table->unsignedInteger('question_id');
            $table->string('translation', 500);
            $table->foreign('questionnaire_language_id', 'questions_questionnaire_language_id_foreign')->references('id')->on('questionnaire_languages');
            $table->foreign('question_id', 'question_id_foreign')->references('id')->on('questionnaire_questions');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questionnaire_translation_questions');
    }
}
