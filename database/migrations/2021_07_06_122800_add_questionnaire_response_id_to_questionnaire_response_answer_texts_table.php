<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionnaireResponseIdToQuestionnaireResponseAnswerTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->unsignedInteger('questionnaire_response_id')->nullable()->after('id');
            $table->foreign('questionnaire_response_id', 'questionnaire_response_id_foreign')->references('id')->on('questionnaire_responses');
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
            $table->dropForeign('questionnaire_response_id_foreign');
            $table->dropColumn('questionnaire_response_id');
        });
    }
}
