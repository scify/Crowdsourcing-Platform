<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('solutions')) {
            Schema::create('solutions', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('problem_id');
                $table->foreign('problem_id')->references('id')->on('problems');

                $table->string('slug')->unique();

                $table->string('img_url');

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('solutions');
    }
};
