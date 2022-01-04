<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleLkpTableSeederAddAnswersModerator extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role_lkp')->insert(array(
            array('id'=> 4, 'name'=>'Answers Moderator')
        ));
    }
}
