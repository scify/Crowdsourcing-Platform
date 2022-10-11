<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireTranslationPossibleAnswersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_translation_possible_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_language_id');
            $table->unsignedInteger('possible_answer_id');
            $table->string('translation', 500);
            $table->foreign('questionnaire_language_id', 'answers_questionnaire_language_id_foreign')->references('id')->on('questionnaire_languages');
            $table->foreign('possible_answer_id', 'possible_answer_id_foreign')->references('id')->on('questionnaire_possible_answers');
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
        Schema::dropIfExists('questionnaire_translation_possible_answers');
    }
}
