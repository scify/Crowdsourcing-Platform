<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesLkpTableSeeder02 extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages_lkp')->insert([
            'id' => 24,
            'language_code' => 'mt',
            'language_name' => 'Maltese',
        ]);
    }
}
