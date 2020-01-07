<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialMediaDataToCrowdSourcingProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crowd_sourcing_projects', function (Blueprint $table) {
            $table->string('sm_title')->nullable()->after('language_id')->comment('
            The title that will be shown when the project URL is posted to social media
            ');
            $table->text('sm_description')->nullable()->after('sm_title')->comment('
            The description that will be shown when the project URL is posted to social media
            ');
            $table->string('sm_featured_img_path')->nullable()->after('sm_description')->comment('
            The path of the image that will be shown when the project URL is posted to social media
            ');
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
            $table->dropColumn('sm_title');
            $table->dropColumn('sm_description');
            $table->dropColumn('sm_featured_img_path');
        });
    }
}
