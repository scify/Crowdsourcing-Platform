<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLandingPageBannerTextsInCrowdSourcingProjectTranslationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('crowd_sourcing_project_translations', function (Blueprint $table) {
            $table->string('banner_title')->nullable()->after('footer');
            $table->text('banner_text')->nullable()->after('banner_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('crowd_sourcing_project_translations', function (Blueprint $table) {
            $table->dropColumn(['banner_title', 'banner_text']);
        });
    }
}
