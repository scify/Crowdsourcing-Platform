<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParsedToQuestionnaireResponseAnswerTextsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->boolean('parsed')->after('answer')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->dropColumn('parsed');
        });
    }
}
