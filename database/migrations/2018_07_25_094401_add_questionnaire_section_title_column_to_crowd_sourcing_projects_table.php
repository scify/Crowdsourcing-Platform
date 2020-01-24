<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionnaireSectionTitleColumnToCrowdSourcingProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->string('questionnaire_section_title', 250)->nullable()->after('about');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            //
        });
    }
}
