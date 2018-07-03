<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert(array(
            array(
                'id' => 1,
                'name' => 'Platform Admin',
                'surname' => '',
                'email' => 'platform-admin@crowd.com',
                'password' => bcrypt(env('DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED '))
            ),
            array(
                'id' => 2,
                'name' => 'Content Manager',
                'surname' => '',
                'email' => 'content-manager@crowd.com',
                'password' => bcrypt(env('DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED '))
            ),
            array(
                'id' => 3,
                'name' => 'Registered User',
                'surname' => '',
                'email' => 'user@crowd.com',
                'password' => bcrypt(env('DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED '))
            ),
        ));
    }
}
