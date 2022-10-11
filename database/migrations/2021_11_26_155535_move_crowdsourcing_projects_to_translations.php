<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MoveCrowdsourcingProjectsToTranslations extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $sql = 'insert into crowd_sourcing_project_translations 
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
                sm_keywords,
                questionnaire_response_email_intro_text,
                questionnaire_response_email_outro_text)
                
                 select  p.id,
                language_id,
                name,
                motto_title,
                motto_subtitle,
                description,
                about,
                footer,
                sm_title,
                sm_description,
                sm_keywords ,
                r.questionnaire_response_email_intro_text,
                r.questionnaire_response_email_outro_text
                from crowd_sourcing_projects p 
                inner join crowd_sourcing_project_communication_resources r on p.communication_resources_id = r.id';

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('translations', function (Blueprint $table) {
            //
        });
    }
}
