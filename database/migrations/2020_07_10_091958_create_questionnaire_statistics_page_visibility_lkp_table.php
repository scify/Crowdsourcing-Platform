<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireStatisticsPageVisibilityLkpTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_statistics_page_visibility_lkp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title', 50);
            $table->string('description', 200);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questionnaire_statistics_page_visibility_lkp');
    }
}
