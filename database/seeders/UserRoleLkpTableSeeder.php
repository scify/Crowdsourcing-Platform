<?php

namespace Database\Seeders;

use App\Models\UserRoleLookup;
use Illuminate\Database\Seeder;

class UserRoleLkpTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user_roles = [
            ['id'=> 1, 'name'=>'Platform Administrator'],
            ['id'=> 2, 'name'=>'Content Manager'],
            ['id'=> 3, 'name'=>'Registered User'],
            ['id'=> 4, 'name'=>'Answers Moderator'],
        ];

        foreach ($user_roles as $user_role) {
            UserRoleLookup::updateOrCreate(['id' => $user_role['id']], $user_role);
        }
    }
}
