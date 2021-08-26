<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslatedResponseJsonToQuestionnaireResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaire_responses', function (Blueprint $table) {
            $table->json('response_json_translated')->after('response_json')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaire_responses', function (Blueprint $table) {
            $table->dropColumn('response_json_translated');
        });
    }
}
