<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('crowd_sourcing_project_translations', function (Blueprint $table) {
            $table->mediumText('footer')->nullable()->change();
            $table->text('sm_description')->nullable()->change();
            $table->text('sm_keywords')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('crowd_sourcing_project_translations', function (Blueprint $table) {
            //
        });
    }
};
