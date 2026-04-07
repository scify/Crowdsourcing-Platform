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

        if (app()->environment() === 'production') {
            exit('You cannot run the seeder in production.');
        }

        $this->call([
            UserRoleLkpTableSeeder::class,
            UsersTableSeeder::class,
            UserRolesTableSeeder::class,
            DemoUserSeeder::class,
            LanguagesLkpTableSeeder::class,
            CrowdSourcingProjectStatusesLkpTableSeeder::class,
            DefaultProjectSeeder::class,
            QuestionnaireStatusesLkpTableSeeder::class,
            QuestionnaireStatisticsPageVisibilityLkpSeeder::class,
            MailChimpListsTableSeeder::class,
            CrowdSourcingProjectColorsSeeder::class,
            QuestionnaireAnswerAdminAnalysisLkpTableSeeder::class,
            QuestionnaireTypesSeeder::class,
            QuestionnaireSeeder::class,
            QuestionnaireStatusHistoryTableSeeder::class,
            QuestionnaireResponsesSeeder::class,
            ProblemStatusLkpSeeder::class,
            SolutionStatusLkpSeeder::class,
            ProblemSeeder::class,
            SolutionSeeder::class,
        ]);
    }
}
