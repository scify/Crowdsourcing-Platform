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
        Schema::create('questionnaire_anonymous_responses', function (Blueprint $table) {
            $table->unsignedBigInteger('response_id');
            $table->foreign('response_id')->references('id')->on('questionnaire_responses');
            $table->string('browser_fingerprint_id');
            $table->string('browser_ip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questionnaire_anonymous_responses');
    }
};
