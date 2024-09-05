<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('crowd_sourcing_project_problem_solutions', function (Blueprint $table) {
            $table->unsignedInteger('user_creator_id')->after('problem_id')->nullable(false);
            $table->foreign('user_creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crowd_sourcing_project_problem_solutions', function (Blueprint $table) {
            //
        });
    }
};
