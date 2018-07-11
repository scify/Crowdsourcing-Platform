<?php

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
            DefaultProjectSeeder::class,
            QuestionnairesSeeder::class,
            QuestionnaireStatusesLkpTableSeeder::class,
            QuestionnaireStatusHistoryTableSeeder::class
        ]);
    }
}
