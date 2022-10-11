<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserQuestionnaireShareTable extends Migration {
    public function up() {
        Schema::create('user_questionnaire_shares', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('questionnaire_id');
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('user_questionnaire_shares');
    }
}
