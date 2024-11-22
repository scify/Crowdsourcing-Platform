<?php

namespace Database\Seeders;

use App\Models\User\UserRole;
use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user_roles = [
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
        ];

        foreach ($user_roles as $user_role) {
            UserRole::updateOrCreate(['id' => $user_role['id']], $user_role);
        }
    }
}
