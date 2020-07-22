<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireQuestionStatisticsColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_question_statistics_colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('questionnaire_question_id');
            $table->foreign('questionnaire_question_id', 'questionnaire_question_stats_colors_q_id_foreign')->references('id')->on('questionnaire_questions');
            $table->unsignedInteger('language_id');
            $table->foreign('language_id', 'questionnaire_question_stats_colors_l_id_foreign')->references('id')->on('languages_lkp');
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_question_statistics_colors');
    }
}
