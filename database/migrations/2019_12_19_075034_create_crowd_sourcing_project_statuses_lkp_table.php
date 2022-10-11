<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdSourcingProjectStatusesLkpTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('crowd_sourcing_project_statuses_lkp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 30);
            $table->string('description', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crowd_sourcing_project_statuses_lkp');
    }
}
