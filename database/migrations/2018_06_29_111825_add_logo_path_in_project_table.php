<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoPathInProjectTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('img_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('logo_path');
        });
    }
}
