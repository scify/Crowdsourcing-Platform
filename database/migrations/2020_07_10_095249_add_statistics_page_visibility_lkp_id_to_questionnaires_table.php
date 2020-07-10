<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatisticsPageVisibilityLkpIdToQuestionnairesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->unsignedBigInteger('statistics_page_visibility_lkp_id')->after('goal')->nullable();
            $table->foreign('statistics_page_visibility_lkp_id')
                ->references('id')->on('questionnaire_statistics_page_visibility_lkp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropForeign('questionnaires_statistics_page_visibility_lkp_id_foreign');
            $table->dropColumn('statistics_page_visibility_lkp_id');
        });
    }
}
