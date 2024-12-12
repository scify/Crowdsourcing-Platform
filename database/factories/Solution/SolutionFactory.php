<?php

namespace Database\Factories\Solution;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Models\Solution\Solution;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolutionFactory extends Factory {
    protected $model = Solution::class;

    public function definition() {
        return [
            'problem_id' => 1,
            'user_creator_id' => 1,
            'slug' => $this->faker->slug,
            'status_id' => SolutionStatusLkp::PUBLISHED,
            'img_url' => $this->faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
