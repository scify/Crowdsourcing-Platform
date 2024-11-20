<?php

namespace Database\Factories\Problem;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectProblemStatusLkp;
use App\Models\Problem\CrowdSourcingProjectProblem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrowdSourcingProjectProblemFactory extends Factory {
    protected $model = CrowdSourcingProjectProblem::class;

    public function definition() {
        return [
            'project_id' => 1,
            'slug' => $this->faker->slug,
            'status_id' => CrowdSourcingProjectProblemStatusLkp::DRAFT,
            'created_at' => now(),
            'updated_at' => now(),
            'user_creator_id' => 1,
            'default_language_id' => 6,
            'img_url' => $this->faker->imageUrl(),
        ];
    }
}
