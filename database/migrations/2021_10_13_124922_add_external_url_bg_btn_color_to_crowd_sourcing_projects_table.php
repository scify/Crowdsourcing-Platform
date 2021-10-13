<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExternalUrlBgBtnColorToCrowdSourcingProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->string('lp_external_url_btn_bg_color')->nullable()->default('#ffffff')->after('lp_external_url_btn_color');
            $table->string('lp_external_url_btn_color')->nullable()->default('#0077FF')->change();
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
            $table->dropColumn('lp_external_url_btn_bg_color');
        });
    }
}
