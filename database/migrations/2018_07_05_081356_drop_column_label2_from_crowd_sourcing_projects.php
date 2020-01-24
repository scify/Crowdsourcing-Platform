<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnLabel2FromCrowdSourcingProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->dropColumn('label2');
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
            //
        });
    }
}
