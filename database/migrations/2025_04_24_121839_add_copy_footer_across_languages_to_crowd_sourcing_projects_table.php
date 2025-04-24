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
            $table->boolean('copy_footer_across_languages')->default(true)->after('display_landing_page_banner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->dropColumn('copy_footer_across_languages');
        });
    }
};
