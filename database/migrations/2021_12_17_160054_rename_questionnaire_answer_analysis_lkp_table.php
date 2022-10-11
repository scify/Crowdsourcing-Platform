<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameQuestionnaireAnswerAnalysisLkpTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::rename('questionnaire_answer_admin_analysis_lkp', 'questionnaire_answer_admin_review_lkp');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::rename('questionnaire_answer_admin_review_lkp', 'questionnaire_answer_admin_analysis_lkp');
    }
}
