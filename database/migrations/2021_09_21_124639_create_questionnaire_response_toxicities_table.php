<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireResponseToxicitiesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_response_toxicities', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('questionnaire_response_id');
            $table->foreign('questionnaire_response_id', 'questionnaire_response_toxicities_response_id_foreign')->references('id')->on('questionnaire_responses');
            $table->string('question_name');
            $table->text('answer_text');
            $table->float('toxicity_score');
            $table->json('toxicity_api_response');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questionnaire_response_toxicities');
    }
}
