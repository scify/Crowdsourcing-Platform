<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('solution_translations')) {
            Schema::create('solution_translations', function (Blueprint $table) {
                $table->unsignedBigInteger('solution_id');
                $table->foreign('solution_id', 'solution_translations_solution_id_foreign')->references('id')->on('solutions');

                $table->unsignedInteger('language_id');
                $table->foreign('language_id', 'solution_translations_language_id_foreign')->references('id')->on('languages_lkp');

                $table->primary(['solution_id', 'language_id'], 'solution_translations_primary');

                $table->string('title', 250);
                $table->text('description');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('solution_translations');
    }
};
