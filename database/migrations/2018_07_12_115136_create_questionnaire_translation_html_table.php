<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireTranslationHtmlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_translation_html', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('questionnaire_language_id');
            $table->unsignedInteger('html_id');
            $table->mediumText('translation');
            $table->foreign('questionnaire_language_id', 'html_questionnaire_language_id_foreign')->references('id')->on('questionnaire_languages');
            $table->foreign('html_id', 'html_id_foreign')->references('id')->on('questionnaire_html');
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
        Schema::dropIfExists('questionnaire_translation_html');
    }
}
