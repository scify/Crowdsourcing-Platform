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
        Schema::create('csp_problem_solution_statuses_lkp', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
            $table->string('description', 200);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csp_problem_solution_statuses_lkp');
    }
};
