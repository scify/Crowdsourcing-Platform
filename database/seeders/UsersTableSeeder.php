<?php

namespace Database\Seeders;

use App\Repository\UserRepository;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "\nRunning User Seeder... pass: ". env('DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED') . "\n";

        $data = [
            [
                'id' => 1,
                'nickname' => 'Platform Admin',
                'email' => 'platform-admin@crowd.com',
                'password' => bcrypt(env('DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED'))
            ],
            [
                'id' => 2,
                'nickname' => 'Content Manager',
                'email' => 'content-manager@crowd.com',
                'password' => bcrypt(env('DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED'))
            ],
            [
                'id' => 3,
                'nickname' => 'Registered User',
                'email' => 'user@crowd.com',
                'password' => bcrypt(env('DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED'))
            ]
        ];

        foreach ($data as $user) {

            $user = $this->userRepository->updateOrCreate(['id' => $user['id']],
                $user);
            echo "\nAdded User: " . $user->name . " with email: " . $user->email . "\n";
        }
    }
}
