<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('crowd_sourcing_project_problem_solution_upvotes', function (Blueprint $table) {
            $table->unsignedBigInteger('solution_id');
            $table->foreign('solution_id', 'csp_problem_solution_upvotes_solution_id_foreign')->references('id')->on('crowd_sourcing_project_problem_solutions');

            $table->unsignedInteger('user_voter_id');
            $table->foreign('user_voter_id', 'csp_problem_solution_upvotes_user_voter_id_foreign')->references('id')->on('users');

            $table->primary(['solution_id', 'user_voter_id'], 'crowd_sourcing_project_problem_solution_upvotes_primary');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('crowd_sourcing_project_problem_solution_upvotes');
    }
};
