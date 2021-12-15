<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddQuestionnaireTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_types', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 150);
        });

        DB::table('questionnaire_types')->insert(array(
            array('name' => "Main Questionnaire | The questionnaire the users are asked to respond for a project"),
            array('name' => "Feedback Questionnaire | The quality assessment questionnaire. User are invited to respond after they have responded to the Main questionnaire"),
        ));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_types');
    }
}
