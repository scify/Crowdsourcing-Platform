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
            $table->boolean('show_file_type_questions_to_statistics_page_audience')->default(false)->after('show_general_statistics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn('show_file_type_questions_to_statistics_page_audience');
        });
    }
};
