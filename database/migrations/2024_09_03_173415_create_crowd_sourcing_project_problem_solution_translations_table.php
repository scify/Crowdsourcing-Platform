<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('crowd_sourcing_project_problem_solution_translations', function (Blueprint $table) {
            $table->unsignedBigInteger('solution_id');
            $table->foreign('solution_id', 'csp_problem_solution_translations_solution_id_foreign')->references('id')->on('crowd_sourcing_project_problem_solutions');

            $table->unsignedInteger('language_id');
            $table->foreign('language_id', 'csp_problem_solution_translations_language_id_foreign')->references('id')->on('languages_lkp');

            $table->primary(['solution_id', 'language_id'], 'crowd_sourcing_project_problem_solution_translations_primary');

            $table->string('title', 250);
            $table->text('description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('crowd_sourcing_project_problem_solution_translations');
    }
};
