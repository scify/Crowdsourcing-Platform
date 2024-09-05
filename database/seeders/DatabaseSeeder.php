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
            DefaultProjectSeeder::class,
            QuestionnaireStatusesLkpTableSeeder::class,
            QuestionnaireStatisticsPageVisibilityLkpSeeder::class,
            MailChimpListsTableSeeder::class,
            CrowdSourcingProjectColorsSeeder::class,
            QuestionnaireAnswerAdminAnalysisLkpTableSeeder::class,
            QuestionnaireTypesSeeder::class,
            QuestionnaireStatisticsPageVisibilityLkpSeeder::class,
            QuestionnaireStatusesLkpTableSeeder::class,
            QuestionnaireSeeder::class,
            QuestionnaireStatusHistoryTableSeeder::class,
            QuestionnaireResponsesSeeder::class,
            CrowdSourcingProjectProblemStatusLkpSeeder::class,
            CrowdSourcingProjectProblemSolutionStatusLkpSeeder::class,
        ]);
    }
}
