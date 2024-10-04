<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Random\RandomException;

class UserFactory extends Factory {
    protected $model = User::class;

    /**
     * @throws RandomException
     */
    public function definition() {
        return [
            'nickname' => $this->faker->name,
            'avatar' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
