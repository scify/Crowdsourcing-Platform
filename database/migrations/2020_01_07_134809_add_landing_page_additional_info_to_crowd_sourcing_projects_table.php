<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLandingPageAdditionalInfoToCrowdSourcingProjectsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->string('lp_motto_color')->nullable()->after('sm_keywords');
            $table->string('lp_about_bg_color')->nullable()->after('lp_motto_color');
            $table->string('lp_about_color')->nullable()->after('lp_about_bg_color');
            $table->string('lp_questionnaire_img_path')->nullable()->after('lp_about_color');
            $table->string('lp_questionnaire_color')->nullable()->after('lp_questionnaire_img_path');
            $table->string('lp_footer_bg_color')->nullable()->after('lp_questionnaire_color');
            $table->string('lp_footer_color')->nullable()->after('lp_footer_bg_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->dropColumn(['lp_motto_color', 'lp_about_bg_color', 'lp_about_color',
                'lp_questionnaire_img_path', 'lp_questionnaire_color', 'lp_footer_bg_color',
                'lp_footer_color', ]);
        });
    }
}
