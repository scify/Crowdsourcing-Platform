<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireResponsesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_id');
            $table->unsignedInteger('user_id');
            $table->longText('response_json');
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('questionnaire_responses');
    }
}
