<?php

namespace Database\Factories\Questionnaire;

use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireTypeLkp;
use App\Models\Questionnaire\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionnaireFactory extends Factory {
    protected $model = Questionnaire::class;

    public function definition() {
        return [
            'project_id' => 1,
            'prerequisite_order' => 1,
            'status_id' => QuestionnaireStatusLkp::DRAFT,
            'type_id' => QuestionnaireTypeLkp::MAIN_QUESTIONNAIRE,
            'default_language_id' => 1,
            'goal' => 10,
            'questionnaire_json' => json_encode([
                'question1' => 'What is your name?',
                'question2' => 'What is your age?',
                'question3' => 'What?']),
            'statistics_page_visibility_lkp_id' => 1,
            'max_votes_num' => 5,
            'show_general_statistics' => true,
            'respondent_auth_required' => false,
            'show_file_type_questions_to_statistics_page_audience' => false,
        ];
    }
}
