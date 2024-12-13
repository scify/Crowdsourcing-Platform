<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->integer('max_votes_per_user_for_solutions')->after('language_id')->default(5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            //
        });
    }
};
