<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('languages_lkp', function (Blueprint $table) {
            $table->boolean('resources_translated')
                ->after('available_for_platform_translation')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('languages_lkp', function (Blueprint $table) {
            //
        });
    }
};
