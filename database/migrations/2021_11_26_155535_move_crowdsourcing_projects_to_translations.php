<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MoveCrowdsourcingProjectsToTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "insert into crowd_sourcing_project_translations 
                (project_id,
                language_id,
                name,
                motto_title,
                motto_subtitle,
                description,
                about,
                footer,
                sm_title,
                sm_description,
                sm_keywords)
                
                select id,
                language_id,
                name,
                motto_title,
                motto_subtitle,
                description,
                about,
                footer,
                sm_title,
                sm_description,
                sm_keywords from crowd_sourcing_projects";

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('translations', function (Blueprint $table) {
            //
        });
    }
}
