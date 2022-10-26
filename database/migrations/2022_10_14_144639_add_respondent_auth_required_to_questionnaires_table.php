<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->boolean('respondent_auth_required')
                ->comment('This controls whether the respondent should be logged in in order to respond.')
                ->default(false)
                ->after('show_general_statistics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn('respondent_auth_required');
        });
    }
};
