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
        echo "\nRunning User Seeder... pass: ". config('app.admin_pass_seed') . "\n";

        $data = [
            [
                'id' => 1,
                'nickname' => 'Platform Admin',
                'email' => 'platform-admin@crowd.com',
                'password' => bcrypt(config('app.admin_pass_seed'))
            ],
            [
                'id' => 2,
                'nickname' => 'Content Manager',
                'email' => 'content-manager@crowd.com',
                'password' => bcrypt(config('app.admin_pass_seed'))
            ],
            [
                'id' => 3,
                'nickname' => 'Registered User',
                'email' => 'user@crowd.com',
                'password' => bcrypt(config('app.admin_pass_seed'))
            ]
        ];

        foreach ($data as $user) {

            $user = $this->userRepository->updateOrCreate(['id' => $user['id']],
                $user);
            echo "\nAdded User: " . $user->name . " with email: " . $user->email . "\n";
        }
    }
}
