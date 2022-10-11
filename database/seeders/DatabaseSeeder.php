<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call([
            UserRoleLkpTableSeeder::class,
            UsersTableSeeder::class,
            UserRolesTableSeeder::class,
            LanguagesLkpTableSeeder::class,
            CrowdSourcingProjectStatusesLkpTableSeeder::class,
            QuestionnaireStatusesLkpTableSeeder::class,
            DefaultProjectSeeder::class,
            QuestionnaireStatisticsPageVisibilityLkpSeeder::class,
            MailChimpListsTableSeeder::class,
            CrowdSourcingProjectColorsSeeder::class,
            UserRoleLkpTableSeederAddAnswersModerator::class,
        ]);
    }
}
