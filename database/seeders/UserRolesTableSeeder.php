<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('user_roles')->delete();
        DB::table('user_roles')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'role_id' => 1,
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'role_id' => 2,
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'role_id' => 3,
            ],
        ]);
    }
}
