<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireFieldsTranslationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questionnaire_fields_translations', function (Blueprint $table) {
            $table->unsignedInteger('questionnaire_id');
            $table->foreign('questionnaire_id', 'questionnaire_fields_translations_q_id_foreign')->references('id')->on('questionnaires');
            $table->unsignedInteger('language_id');
            $table->foreign('language_id', 'questionnaire_fields_translations_l_id_foreign')->references('id')->on('languages_lkp');
            $table->string('title');
            $table->text('description');
            $table->primary(['questionnaire_id', 'language_id'], 'questionnaire_fields_translations_q_l_primary');
            $table->timestamps();
        });
        if (Schema::hasColumn('questionnaires', 'title')) {
            $sql = 'insert into questionnaire_fields_translations 
                (questionnaire_id,
                language_id,
                title,
                description)
                
                 select  q.id,
                default_language_id,
                title,
                description
                from questionnaires q';
            DB::statement($sql);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questionnaire_fields_translations');
    }
}
