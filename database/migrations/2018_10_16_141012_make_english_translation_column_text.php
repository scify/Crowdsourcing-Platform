<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEnglishTranslationColumnText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint  $table) {
            $table->text('english_translation')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaire_response_answer_texts', function (Blueprint  $table) {
            $table->string('english_translation')->change();
        });
    }
}
