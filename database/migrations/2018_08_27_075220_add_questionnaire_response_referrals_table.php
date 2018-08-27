<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionnaireResponseReferralsTable extends Migration
{

    public function up()
    {
        Schema::create('questionnaire_response_referrals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_id');
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->unsignedInteger('respondent_id')->comment('The user who clicked on the share link and answered the questionnaire');
            $table->foreign('respondent_id')->references('id')->on('users');
            $table->unsignedInteger('referrer_id')->comment('The user who shared the link with the questionnaire');
            $table->foreign('referrer_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_response_referrals');
    }
}
