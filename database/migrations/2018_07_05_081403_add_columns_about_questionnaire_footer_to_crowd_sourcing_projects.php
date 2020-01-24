<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsAboutQuestionnaireFooterToCrowdSourcingProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->mediumText('footer')->nullable()->after('description');
            $table->mediumText('questionnaire')->nullable()->after('description');
            $table->mediumText('about')->nullable()->after('description');
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
