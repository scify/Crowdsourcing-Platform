<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireResponseAnswerTextsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_response_answer_id');
            $table->longText('answer');
            $table->foreign('questionnaire_response_answer_id', 'response_answer_id_foreign')->references('id')->on('questionnaire_response_answers');
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
        Schema::dropIfExists('questionnaire_response_answer_texts');
    }
}
