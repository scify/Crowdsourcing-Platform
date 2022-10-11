<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireBasicStatisticsColorsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_basic_statistics_colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('questionnaire_id')->unique();
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->string('total_responses_color')->nullable();
            $table->string('goal_responses_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questionnaire_basic_statistics_colors');
    }
}
