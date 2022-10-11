<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTranslatableColumnsFromCrowdSourcingProjectsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'description',
                'motto_title',
                'motto_subtitle',
                'about',
                'footer',
                'sm_title',
                'sm_description',
                'sm_keywords',
            ]);
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
