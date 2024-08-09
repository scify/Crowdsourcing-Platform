<?php

namespace Database\Factories\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireAnswerVote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestionnaireAnswerVoteFactory extends Factory {
    protected $model = QuestionnaireAnswerVote::class;

    public function definition(): array {
        return [
            'question_name' => $this->faker->name(),
            'upvote' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'questionnaire_id' => Questionnaire::factory(),
            'respondent_user_id' => User::factory(),
            'voter_user_id' => User::factory(),
        ];
    }
}
