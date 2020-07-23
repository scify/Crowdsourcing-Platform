<?php

namespace App\Repository\Questionnaire\Statistics;

use Illuminate\Support\Facades\DB;

class QuestionnaireStatisticsRepositoryMock {

    public function getQuestionnaireResponseStatistics($questionnaireId) {
        return new QuestionnaireResponseStatistics(100, 150);
    }

    public function getNumberOfResponsesPerLanguage($questionnaireid) {
        $data = [
            [
                'language_name' => 'English',
                'language_code' => 'en',
                'num_responses' => 35
            ],
            [
                'language_name' => 'German',
                'language_code' => 'ge',
                'num_responses' => 28
            ],
            [
                'language_name' => 'Italian',
                'language_code' => 'it',
                'num_responses' => 13
            ],
            [
                'language_name' => 'Spanish',
                'language_code' => 'es',
                'num_responses' => 24
            ],
            [
                'language_name' => 'Greek',
                'language_code' => 'gr',
                'num_responses' => 19
            ]
        ];

        return new QuestionnaireResponsesPerLanguage($data);
    }

    // question_type : fixed_choices | free_text
    public function getStatisticsPerQuestion($questionnaire) {
        $data = [
            [
                'question_id' => 1,
                'question_title' => 'Title 1',
                'question_type' => 'fixed_choices',
                'statistics' => $this->getStatisticsForFixedChoicesQuestion(1)
            ],
            [
                'question_id' => 2,
                'question_title' => 'Title 2',
                'question_type' => 'free_text',
                'statistics' => $this->getStatisticsForFreeTextQuestion(2)
            ]
        ];

        return $data;
    }

    protected function getStatisticsForFixedChoicesQuestion(int $questionId) {
        $data = [
            [
                'answer_title' => 'answer 1',
                'num_responses' => 10
            ],
            [
                'answer_title' => 'answer 2',
                'num_responses' => 19
            ],
            [
                'answer_title' => 'answer 3',
                'num_responses' => 12
            ]
        ];

        return $data;
    }

    protected function getStatisticsForFreeTextQuestion(int $questionId) {
        $data = [
            [
                'answer_text' => 'answer 5 (google translate)',
                'is_translated' => true,
                'answer_original_text' => 'answer 3',
                'origin_language' => [
                    'language_name' => 'Spanish',
                    'language_code' => 'es'
                ]
            ],
            [
                'answer_text' => 'answer 6',
                'is_translated' => false,
                'answer_original_text' => 'answer 6',
                'origin_language' => [
                    'language_name' => 'Greek',
                    'language_code' => 'el'
                ]
            ],
            [
                'answer_text' => 'answer 6 French answer translated',
                'is_translated' => true,
                'answer_original_text' => 'answer 6 French answer',
                'origin_language' => [
                    'language_name' => 'French',
                    'language_code' => 'fr'
                ]
            ]
        ];

        return $data;
    }
}
