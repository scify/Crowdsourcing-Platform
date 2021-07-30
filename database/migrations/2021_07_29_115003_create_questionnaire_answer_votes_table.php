<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireAnswerVotesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_answer_votes', function (Blueprint $table) {

            $table->unsignedInteger('questionnaire_id');
            $table->foreign('questionnaire_id', 'questionnaire_answer_votes_questionnaire_id_foreign')
                ->references('id')->on('questionnaires');

            $table->string('question_name');

            $table->unsignedInteger('respondent_user_id');
            $table->foreign('respondent_user_id', 'questionnaire_answer_votes_respondent_id_foreign')
                ->references('id')->on('users');

            $table->unsignedInteger('voter_user_id');
            $table->foreign('voter_user_id', 'questionnaire_answer_votes_voter_user_id_foreign')
                ->references('id')->on('users');

            $table->boolean('upvote');

            $table->primary(['questionnaire_id', 'question_name', 'respondent_user_id', 'voter_user_id'], 'project_questionnaires_primary');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questionnaire_answer_votes');
    }
}
