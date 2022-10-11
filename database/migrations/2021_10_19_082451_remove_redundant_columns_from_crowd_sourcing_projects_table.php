<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveRedundantColumnsFromCrowdSourcingProjectsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->dropColumn([
                'lp_motto_color',
                'lp_external_url_btn_color',
                'lp_external_url_btn_bg_color',
                'lp_motto_inner_bg_color',
                'lp_about_img_path',
                'lp_about_color',
                'lp_about_bg_color',
                'lp_questionnaire_color',
                'lp_questionnaire_btn_color',
                'lp_questionnaire_btn_bg_color',
                'lp_questionnaire_goal_title_color',
                'lp_questionnaire_goal_color',
                'lp_questionnaire_goal_bg_color',
                'lp_newsletter_bg_color',
                'lp_newsletter_title_color',
                'lp_newsletter_color',
                'lp_newsletter_btn_color',
                'lp_newsletter_btn_bg_color',
                'lp_footer_bg_color',
                'lp_footer_color',
            ]);

            $table->renameColumn('lp_motto_overlay_color', 'lp_primary_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            //
        });
    }
}
