<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireResponseAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_response_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_response_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('answer_id')->nullable();
            $table->foreign('questionnaire_response_id')->references('id')->on('questionnaire_responses');
            $table->foreign('question_id')->references('id')->on('questionnaire_questions');
            $table->foreign('answer_id')->references('id')->on('questionnaire_possible_answers');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_response_answers');
    }
}
