<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('questionnaire_status_history', function (Blueprint $table) {
            // Check if the status_id column exists
            if (Schema::hasColumn('questionnaire_status_history', 'status_id')) {
                // Make the status_id column nullable
                $table->unsignedInteger('status_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
    }
};
