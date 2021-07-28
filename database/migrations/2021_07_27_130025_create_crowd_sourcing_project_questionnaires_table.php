<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdSourcingProjectQuestionnairesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('crowd_sourcing_project_questionnaires', function (Blueprint $table) {
            $table->unsignedInteger('project_id');
            $table->foreign('project_id', 'project_questionnaires_project_id_foreign')->references('id')->on('crowd_sourcing_projects');
            $table->unsignedInteger('questionnaire_id');
            $table->foreign('questionnaire_id', 'project_questionnaires_questionnaire_id_foreign')->references('id')->on('questionnaires');
            $table->primary(['project_id', 'questionnaire_id'], 'project_questionnaires_primary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crowd_sourcing_project_questionnaires');
    }
}
