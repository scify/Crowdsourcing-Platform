<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('crowd_sourcing_project_problems', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('project_id');
            $table->foreign('project_id')->references('id')->on('crowd_sourcing_projects');

            $table->string('slug')->unique();

            $table->string('img_url');

            $table->unsignedInteger('default_language_id');
            $table->foreign('default_language_id')->references('id')->on('languages_lkp');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('crowd_sourcing_project_problems');
    }
};