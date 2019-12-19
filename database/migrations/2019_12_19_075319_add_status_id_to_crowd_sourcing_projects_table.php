<?php

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusIdToCrowdSourcingProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->unsignedInteger('status_id')->nullable()->after('id');
            $table->foreign('status_id')->references('id')->on('crowd_sourcing_project_statuses_lkp');
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
            $table->dropForeign('crowd_sourcing_projects_status_id_foreign');
            $table->dropColumn('status_id');
        });
    }
}
