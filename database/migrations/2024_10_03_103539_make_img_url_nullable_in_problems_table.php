<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('crowd_sourcing_project_problems', function (Blueprint $table) {
            $table->string('img_url')->nullable()->change();
        });
    }
};
