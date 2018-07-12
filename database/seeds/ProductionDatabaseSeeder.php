<?php

use Illuminate\Database\Seeder;

class ProductionDatabaseSeeder extends Seeder
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
            QuestionnaireStatusesLkpTableSeeder::class,
            QuestionnairesSeeder::class,
            QuestionnaireStatusHistoryTableSeeder::class
        ]);
    }
}
