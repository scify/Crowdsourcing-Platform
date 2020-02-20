<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdSourcingProjectCommunicationResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crowd_sourcing_project_communication_resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('questionnaire_response_email_intro_text')->nullable();
            $table->longText('questionnaire_response_email_outro_text')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crowd_sourcing_project_communication_resources');
    }
}
