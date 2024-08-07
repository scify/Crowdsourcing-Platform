<?php

namespace Database\Factories\Questionnaire;

use App\Models\Questionnaire\QuestionnaireLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionnaireLanguageFactory extends Factory {
    protected $model = QuestionnaireLanguage::class;

    public function definition(): array {
        return [
            'questionnaire_id' => 1,
            'language_id' => 1,
            'human_approved' => 1,
            'color' => '#000000',
        ];
    }
}
