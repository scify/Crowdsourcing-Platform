<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (Schema::hasColumn('solutions', 'status_id')) {
            return;
        }
        Schema::table('solutions', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->after('slug')->nullable(false);
            $table->foreign('status_id')->references('id')->on('solution_statuses_lkp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('solutions', function (Blueprint $table) {
            //
        });
    }
};