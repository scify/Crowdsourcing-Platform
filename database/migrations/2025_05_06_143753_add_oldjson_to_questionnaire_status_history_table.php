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
            $table->longText('old_json')->nullable()->after('current_json');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
