<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireLanguagesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_id');
            $table->unsignedInteger('language_id');
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->foreign('language_id')->references('id')->on('languages_lkp');
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
        Schema::dropIfExists('questionnaire_languages');
    }
}
