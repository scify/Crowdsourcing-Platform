<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('problem_statuses_lkp')) {
            Schema::create('problem_statuses_lkp', function (Blueprint $table) {
                $table->id();
                $table->string('title', 30);
                $table->string('description', 200);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('problem_statuses_lkp');
    }
};
