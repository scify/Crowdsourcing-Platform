<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowSpeakUpButtonToCrowdSourcingProjects extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->boolean('lp_show_speak_up_btn')->default(true)->after('lp_footer_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->dropColumn('lp_show_speak_up_btn');
        });
    }
}
