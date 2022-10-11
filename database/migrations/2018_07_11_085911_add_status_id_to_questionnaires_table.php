<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusIdToQuestionnairesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->unsignedInteger('status_id')->after('project_id')->default(1);
            $table->foreign('status_id')->references('id')->on('questionnaire_statuses_lkp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaires', function (Blueprint $table) {
            //
        });
    }
}
