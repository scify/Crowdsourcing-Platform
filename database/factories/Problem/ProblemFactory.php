<?php

namespace Database\Factories\Problem;

use App\BusinessLogicLayer\lkp\ProblemStatusLkp;
use App\Models\Problem\Problem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProblemFactory extends Factory {
    protected $model = Problem::class;

    public function definition() {
        return [
            'project_id' => 1,
            'slug' => $this->faker->slug,
            'status_id' => ProblemStatusLkp::DRAFT,
            'created_at' => now(),
            'updated_at' => now(),
            'user_creator_id' => 1,
            'default_language_id' => 6,
            'img_url' => $this->faker->imageUrl(),
        ];
    }
}
