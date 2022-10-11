<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireStatusesLkpTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('questionnaire_statuses_lkp')->delete();
        DB::table('questionnaire_statuses_lkp')->insert([
            ['id' => 1, 'title' => 'Draft', 'description' => 'The questionnaire is still under development.'],
            ['id' => 2, 'title' => 'Published', 'description' => 'The questionnaire is released and citizens can respond to it.'],
            ['id' => 3, 'title' => 'Finalized', 'description' => 'The questionnaire should not accept any new responses.'],
            ['id' => 4, 'title' => 'Unpublished', 'description' => 'The questionnaire is not available online anymore.'],
            ['id' => 5, 'title' => 'Deleted', 'description' => 'The questionnaire has been archived.'],
        ]);
    }
}
