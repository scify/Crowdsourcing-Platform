<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('csp_problem_user_bookmarks', function (Blueprint $table) {
            $table->unsignedBigInteger('problem_id');
            $table->foreign('problem_id')->references('id')->on('crowd_sourcing_project_problems');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['problem_id', 'user_id'], 'csp_problem_user_bookmarks_primary');

            // the language in which the user bookmarked the problem
            $table->unsignedInteger('problem_bookmark_language_id');
            $table->foreign('problem_bookmark_language_id')->references('id')->on('languages_lkp');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('csp_problem_user_bookmarks');
    }
};
