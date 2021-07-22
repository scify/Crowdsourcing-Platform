<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeederRunOnEmptyDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserRoleLkpTableSeeder::class,
            UsersTableSeeder::class,
            UserRolesTableSeeder::class,
            LanguagesLkpTableSeeder::class,
            CrowdSourcingProjectStatusesLkpTableSeeder::class,
            QuestionnaireStatusesLkpTableSeeder::class,
            DefaultProjectSeeder::class,
            QuestionnairesSeeder::class,
            QuestionnaireStatusHistoryTableSeeder::class,
            MailChimpListsTableSeeder::class,
            ProduceAPITokenForDefaultAdmin::class,
            CrowdSourcingProjectColorsSeeder::class
        ]);
    }
}
