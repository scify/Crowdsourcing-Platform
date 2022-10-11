<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnairesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('default_language_id');
            $table->string('title', 250);
            $table->text('description');
            $table->integer('goal');
            $table->longText('questionnaire_json');
            $table->foreign('project_id')->references('id')->on('crowd_sourcing_projects');
            $table->foreign('default_language_id')->references('id')->on('languages_lkp');
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
        Schema::dropIfExists('questionnaires');
    }
}
