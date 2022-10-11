<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTranslationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $sql = "CREATE TABLE `crowd_sourcing_project_translations` (
                      `id` int unsigned NOT NULL AUTO_INCREMENT,
                      `language_id` int unsigned NOT NULL DEFAULT '6',
                      `project_id` int unsigned NOT NULL,
                      `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                      `motto_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                      `motto_subtitle` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                      `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                      `about` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                      `footer` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                      `sm_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '\n            The title that will be shown when the project URL is posted to social media\n            ',
                      `sm_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '\n            The description that will be shown when the project URL is posted to social media\n            ',
                      `sm_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '\n            Comma-separated words that will be shown as keywords when the project URL is posted to social media\n            ',
                      `questionnaire_response_email_intro_text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                      `questionnaire_response_email_outro_text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                      `created_at` timestamp NULL DEFAULT NULL,
                      `updated_at` timestamp NULL DEFAULT NULL,
                      `deleted_at` timestamp NULL DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `index2` (`language_id`,`project_id`),
                      CONSTRAINT `fk_crowd_sourcing_project_translations_1` FOREIGN KEY (`language_id`) REFERENCES `languages_lkp` (`id`),
                      CONSTRAINT `fk_crowd_sourcing_project_translations_2` FOREIGN KEY (`project_id`) REFERENCES `crowd_sourcing_projects` (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                    ";
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('crowd_sourcing_project_translations');
    }
}
