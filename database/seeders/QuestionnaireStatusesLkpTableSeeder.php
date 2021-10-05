<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireStatusesLkpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questionnaire_statuses_lkp')->delete();
        DB::table('questionnaire_statuses_lkp')->insert(array(
            array('id' => 1, 'title' => 'Draft', 'description' => 'The questionnaire is still under development.'),
            array('id' => 2, 'title' => 'Published', 'description' => 'The questionnaire is released and citizens can respond to it.'),
            array('id' => 3, 'title' => 'Finalized', 'description' => 'The questionnaire should not accept any new responses.'),
            array('id' => 4, 'title' => 'Unpublished', 'description' => 'The questionnaire is not available online anymore.'),
            array('id' => 5, 'title' => 'Deleted', 'description' => 'The questionnaire has been archived.')
        ));
    }
}
