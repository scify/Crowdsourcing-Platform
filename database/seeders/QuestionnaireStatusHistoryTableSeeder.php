<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireStatusHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questionnaire_status_history')->delete();
        DB::table('questionnaire_status_history')->insert(array(
            array('id' => 1, 'questionnaire_id' => 1, 'status_id' => 1, 'comments' => '')
        ));
    }
}
