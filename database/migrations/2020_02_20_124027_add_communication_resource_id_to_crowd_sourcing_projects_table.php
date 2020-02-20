<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommunicationResourceIdToCrowdSourcingProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->unsignedBigInteger('communication_resources_id')->nullable()->after('language_id');
            $table->foreign('communication_resources_id')->references('id')->on('crowd_sourcing_project_communication_resources');
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
            $table->dropForeign('crowd_sourcing_projects_communication_resources_id_foreign');
            $table->dropColumn('communication_resources_id');
        });
    }
}
