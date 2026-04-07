<?php

namespace Database\Seeders;

use App\Models\User\User;
use App\Models\User\UserRole;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder {
    public function run(): void {
        $users = [
            [
                'id' => 4,
                'nickname' => 'Demo User',
                'email' => 'demo-user@demo.com',
                'role_id' => 3,
            ],
            [
                'id' => 5,
                'nickname' => 'Demo Admin',
                'email' => 'demo-admin@demo.com',
                'role_id' => 1,
            ],
        ];

        foreach ($users as $userData) {
            $roleId = $userData['role_id'];
            unset($userData['role_id']);
            $userData['password'] = bcrypt(config('app.admin_pass_seed'));
            $userData['avatar'] = '/images/user.webp';

            $user = User::updateOrCreate(['id' => $userData['id']], $userData);

            UserRole::updateOrCreate(
                ['user_id' => $user->id, 'role_id' => $roleId],
                ['user_id' => $user->id, 'role_id' => $roleId]
            );

            if (app()->environment() !== 'testing') {
                echo "\nAdded Demo User: {$user->nickname} ({$user->email})\n";
            }
        }
    }
}
