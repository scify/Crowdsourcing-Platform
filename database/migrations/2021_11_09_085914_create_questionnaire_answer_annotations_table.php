<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireAnswerAnnotationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_answer_annotations', function (Blueprint $table) {
            $table->unsignedInteger('questionnaire_id');
            $table->foreign('questionnaire_id', 'questionnaire_answer_annotations_questionnaire_id_foreign')
                ->references('id')->on('questionnaires');

            $table->string('question_name');

            $table->unsignedInteger('respondent_user_id');
            $table->foreign('respondent_user_id', 'questionnaire_answer_annotations_respondent_id_foreign')
                ->references('id')->on('users');

            $table->unsignedInteger('annotator_user_id');
            $table->foreign('annotator_user_id', 'questionnaire_answer_annotations_annotator_user_id_foreign')
                ->references('id')->on('users');

            $table->text('annotation_text');

            $table->primary(['questionnaire_id', 'question_name', 'respondent_user_id', 'annotator_user_id'], 'questionnaire_answer_annotations_primary');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questionnaire_answer_annotations');
    }
}
