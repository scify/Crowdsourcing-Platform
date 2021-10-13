<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectLandingPageUiElementsToCrowdSourcingProjectsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->string('lp_motto_overlay_color')->nullable()->after('lp_motto_color');
            $table->string('lp_motto_inner_bg_color')->nullable()->after('lp_motto_overlay_color');
            $table->string('lp_external_url_btn_color')->nullable()->after('lp_motto_overlay_color');
            $table->string('lp_about_img_path')->nullable()->after('lp_about_bg_color');
            $table->string('motto_subtitle')->nullable()->after('motto');
            $table->renameColumn('motto', 'motto_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->dropColumn(['lp_motto_overlay_color', 'lp_external_url_btn_color', 'lp_about_img_path', 'lp_motto_inner_bg_color', 'motto_subtitle']);
        });
    }
}
