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
        Schema::dropIfExists('questionnaire_anonymous_responses');
        Schema::table('questionnaire_responses', function (Blueprint $table) {
            $table->string('browser_fingerprint_id')->after('language_id')->nullable();
            $table->string('browser_ip')->after('browser_fingerprint_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
};
