<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminReviewStatusIdToQuestionnaireAnswerAnnotationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('questionnaire_answer_annotations', function (Blueprint $table) {
            $table->string('admin_review_comment')->after('annotation_text')->nullable(true);
            $table->unsignedInteger('admin_review_status_id')->after('annotation_text')->nullable(true);
            $table->foreign('admin_review_status_id', 'quest_answer_ann_admin_review_status_id_foreign')
                ->references('id')->on('questionnaire_answer_admin_analysis_lkp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('questionnaire_answer_annotations', function (Blueprint $table) {
            $table->dropForeign('quest_answer_ann_admin_review_status_id_foreign');
            $table->dropColumn(['admin_review_comment', 'admin_review_status_id']);
        });
    }
}
