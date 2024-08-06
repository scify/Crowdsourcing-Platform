<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTranslationsTable extends Migration {
    public function up() {
        Schema::create('crowd_sourcing_project_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('language_id')->default(6);
            $table->unsignedInteger('project_id');
            $table->string('name', 191);
            $table->string('motto_title', 191);
            $table->string('motto_subtitle', 191)->nullable();
            $table->longText('description');
            $table->mediumText('about');
            $table->mediumText('footer');
            $table->string('sm_title', 191)->nullable()->comment('The title that will be shown when the project URL is posted to social media');
            $table->text('sm_description')->comment('The description that will be shown when the project URL is posted to social media');
            $table->text('sm_keywords')->comment('Comma-separated words that will be shown as keywords when the project URL is posted to social media');
            $table->longText('questionnaire_response_email_intro_text')->nullable();
            $table->longText('questionnaire_response_email_outro_text')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['language_id', 'project_id'], 'index2');
            $table->foreign('language_id')->references('id')->on('languages_lkp')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('crowd_sourcing_projects')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('crowd_sourcing_project_translations');
    }
}
