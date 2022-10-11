<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrerequisiteOrderColumnToQuestionnairesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->integer('prerequisite_order')->nullable()->after('project_id')->comment('
            Number that states the order in which the questionnaires of a project must be answered
            ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn(['prerequisite_order']);
        });
    }
}
