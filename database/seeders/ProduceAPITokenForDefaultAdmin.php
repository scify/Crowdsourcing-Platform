<?php
namespace Database\Seeders;

use App\Repository\UserRepository;
use Illuminate\Database\Seeder;

class ProduceAPITokenForDefaultAdmin extends Seeder
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
    public function run()
    {
        $user = $this->userRepository->find(1);
        $token = $user->createToken('api-token');

        echo "\nAPI Token for user: " . $user->email . " is: " . $token->plainTextToken . "\n";
        echo "\nMAKE SURE TO STORE THIS TOKEN IN THE .env file, in 'API_AUTH_TOKEN' field, AND RUN 'npm run dev' or 'npm run prod'.\n\n";
    }
}
