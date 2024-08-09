<?php

namespace Database\Factories\Questionnaire;

use App\Models\Questionnaire\QuestionnaireResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionnaireResponseFactory extends Factory {
    protected $model = QuestionnaireResponse::class;

    /**
     * {@inheritDoc}
     */
    public function definition() {
        return [
            'questionnaire_id' => 1,
            'user_id' => 1,
            'project_id' => 1,
            'response_json' => json_encode([
                'question1' => 5,
                'question5' => 'item1',
                'question4' => [
                    'item1' => 'answer1',
                    'item2' => 'answer2',
                ],
            ]),
            'language_id' => 1,
            'browser_ip' => '123',
            'browser_fingerprint_id' => 'test_fingerprint',
        ];
    }
}
