<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('problem_translations')) {
            Schema::create('problem_translations', function (Blueprint $table) {
                $table->unsignedBigInteger('problem_id');
                $table->foreign('problem_id')->references('id')->on('problems');

                $table->unsignedInteger('language_id');
                $table->foreign('language_id')->references('id')->on('languages_lkp');

                $table->primary(['problem_id', 'language_id'], 'problem_translations_primary');

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
        Schema::dropIfExists('problem_translations');
    }
};
