<?php

namespace Database\Factories\Problem;

use App\Models\Problem\ProblemTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProblemTranslationFactory extends Factory {
    protected $model = ProblemTranslation::class;

    public function definition() {
        return [
            'problem_id' => 1,
            'language_id' => 6,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }
}
