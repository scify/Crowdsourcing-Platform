<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (Schema::hasColumn('crowd_sourcing_projects', 'lp_btn_text_color_theme')) {
            return;
        }
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->string('lp_btn_text_color_theme')->after('lp_primary_color')->default('light')->nullable(false);
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
