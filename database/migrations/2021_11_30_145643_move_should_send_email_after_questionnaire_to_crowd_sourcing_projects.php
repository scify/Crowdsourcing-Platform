<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MoveShouldSendEmailAfterQuestionnaireToCrowdSourcingProjects extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->boolean('should_send_email_after_questionnaire_response')->after('language_id')->default(1);
        });
        if (Schema::hasColumn('crowd_sourcing_project_communication_resources', 'should_send_email_after_questionnaire_response')) {
            $sql = 'UPDATE crowd_sourcing_projects
                INNER JOIN crowd_sourcing_project_communication_resources cr ON cr.id = crowd_sourcing_projects.communication_resources_id
                SET crowd_sourcing_projects.should_send_email_after_questionnaire_response = cr.should_send_email_after_questionnaire_response';
            DB::statement($sql);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            //
        });
    }
}
