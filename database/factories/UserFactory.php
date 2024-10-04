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
            'id' => $this->faker->unique()->numberBetween(1, 10000),
            'nickname' => $this->faker->name,
            'avatar' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
