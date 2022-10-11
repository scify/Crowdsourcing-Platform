<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslationColumnsInQuestionnaireResponseAnswerTextTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->string('english_translation')->nullable()->after('answer');
            $table->string('initial_language_detected')->nullable()->after('english_translation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint $table) {
            $table->dropColumn(['english_translation', 'initial_language_detected']);
        });
    }
}
