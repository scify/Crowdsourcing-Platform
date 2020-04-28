<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShouldSendCongratulationsEmailToCrowdSourcingProjectCommunicationResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_project_communication_resources', function (Blueprint $table) {
            $table->boolean('should_send_email_after_questionnaire_response')->after('id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crowd_sourcing_project_communication_resources', function (Blueprint $table) {
            $table->dropColumn('should_send_email_after_questionnaire_response');
        });
    }
}
