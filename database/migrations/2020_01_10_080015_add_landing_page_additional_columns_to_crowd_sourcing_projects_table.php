<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLandingPageAdditionalColumnsToCrowdSourcingProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->string('lp_questionnaire_btn_color')->nullable()->after('lp_questionnaire_color');
            $table->string('lp_questionnaire_btn_bg_color')->nullable()->after('lp_questionnaire_btn_color');
            $table->string('lp_questionnaire_goal_title_color')->nullable()->after('lp_questionnaire_btn_bg_color');
            $table->string('lp_questionnaire_goal_color')->nullable()->after('lp_questionnaire_goal_title_color');
            $table->string('lp_questionnaire_goal_bg_color')->nullable()->after('lp_questionnaire_goal_color');
            $table->string('lp_newsletter_bg_color')->nullable()->after('lp_questionnaire_goal_bg_color');
            $table->string('lp_newsletter_title_color')->nullable()->after('lp_newsletter_bg_color');
            $table->string('lp_newsletter_color')->nullable()->after('lp_newsletter_title_color');
            $table->string('lp_newsletter_btn_color')->nullable()->after('lp_newsletter_color');
            $table->string('lp_newsletter_btn_bg_color')->nullable()->after('lp_newsletter_btn_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->dropColumn([
                'lp_questionnaire_btn_color', 'lp_questionnaire_btn_bg_color',
                'lp_questionnaire_goal_title_color', 'lp_questionnaire_goal_color',
                'lp_questionnaire_goal_bg_color', 'lp_newsletter_bg_color',
                'lp_newsletter_title_color', 'lp_newsletter_color',
                'lp_newsletter_bg_color', 'lp_newsletter_btn_color',
                'lp_newsletter_btn_bg_color'
            ]);
        });
    }
}
