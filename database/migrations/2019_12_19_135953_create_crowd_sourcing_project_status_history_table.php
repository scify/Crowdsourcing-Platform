<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdSourcingProjectStatusHistoryTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('crowd_sourcing_project_status_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('status_id');
            $table->string('comments', 250);
            $table->foreign('project_id')->references('id')->on('crowd_sourcing_projects');
            $table->foreign('status_id')->references('id')->on('crowd_sourcing_project_statuses_lkp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crowd_sourcing_project_status_history');
    }
}
