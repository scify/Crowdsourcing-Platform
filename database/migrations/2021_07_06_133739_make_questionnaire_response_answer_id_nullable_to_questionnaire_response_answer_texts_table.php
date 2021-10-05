<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeQuestionnaireResponseAnswerIdNullableToQuestionnaireResponseAnswerTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->unsignedInteger('questionnaire_response_answer_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->unsignedInteger('questionnaire_response_answer_id')->nullable(false)->change();
        });
    }
}
