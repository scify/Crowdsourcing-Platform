<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInQuestionnaireLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaire_languages', function (Blueprint $table) {
            $table->boolean('machine_generated_translation')->nullable()->default(false)->change();
            $table->renameColumn('machine_generated_translation', 'human_approved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaire_languages', function (Blueprint $table) {
            $table->renameColumn('human_approved', 'machine_generated_translation');
        });
    }
}
