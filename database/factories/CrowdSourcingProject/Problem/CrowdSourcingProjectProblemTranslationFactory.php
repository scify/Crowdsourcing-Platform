<?php

namespace Database\Factories\CrowdSourcingProject\Problem;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrowdSourcingProjectProblemTranslationFactory extends Factory {
    protected $model = CrowdSourcingProjectProblemTranslation::class;

    public function definition() {
        return [
            'problem_id' => 1,
            'language_id' => 6,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }

}