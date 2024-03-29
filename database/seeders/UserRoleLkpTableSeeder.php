<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleLkpTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('user_role_lkp')->delete();
        DB::table('user_role_lkp')->insert([
            ['id'=> 1, 'name'=>'Platform Administrator'],
            ['id'=> 2, 'name'=>'Content Manager'],
            ['id'=> 3, 'name'=>'Registered User'],
        ]);
    }
}
