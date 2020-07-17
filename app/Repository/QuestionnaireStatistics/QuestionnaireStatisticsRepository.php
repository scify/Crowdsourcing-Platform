<?php

namespace App\Repository\QuestionnaireStatistics;

use Illuminate\Support\Facades\DB;

class QuestionnaireStatisticsRepository {

    public function getQuestionnaireResponseStatistics($questionnaireId) {
        return new QuestionnaireResponseStatistics(100, 150);
    }

    public function getNumberOfResponsesPerLanguage($questionnaireId) {
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

    // return both fixed and freetext
    public function getStatisticsPerQuestion($questionnaire) {
        $questionIDsForQuestionnaire = DB::select('select id, type, question as title from questionnaire_questions
                                                 where questionnaire_id = ' . $questionnaire->id .
                                                 ' and deleted_at is null');
        $statisticsPerQuestionnaire = array();
        foreach ($questionIDsForQuestionnaire as $question) {
            // separate for each type
            $questionType = '';
            if ($question->type == 'radiogroup' || $question->type == 'checkbox') {
                $questionType = 'fixed_choices';
                $questionStatistics = $this->getStatisticsForFixedChoicesQuestion($question->id);
            } elseif ($question->type == 'text' || $question->type == 'comment') {
                $questionType = 'free_text';
                $questionStatistics = $this->getStatisticsForFreeTextQuestion($question->id);
            }
            if (strlen($questionType) > 0) {
                $statisticsPerQuestionnaire[] = [
                    'question_id' => $question->id,
                    'question_title' => $questionStatistics[0]['title'],
                    'question_type' => $questionType,
                    'statistics' => $questionStatistics
                ];
            }
        }

        return $statisticsPerQuestionnaire;
    }

    private function getStatisticsForFixedChoicesQuestion(int $questionId) {
        $query = DB::select('
            select question as title, qpa.answer as answer_title, count(*) as num_responses from questionnaire_response_answers as qra
                inner join questionnaire_questions as qq on qra.question_id = qq.id
                inner join questionnaire_possible_answers as qpa on answer_id = qpa.id
            where qq.id = ' . $questionId . ' and qra.deleted_at is null
            group by question, qpa.answer
        ');
        $query = collect($query)->map(function($x) { return (array) $x;} )->toArray();

        return $query;
    }

    protected function getStatisticsForFreeTextQuestion(int $questionId) {
        // TODO
        $data = [
            [
                'title' => 'Title free text',
                'answer_text' => 'answer 5 (google translate)',
                'is_translated' => true,
                'answer_original_text' => 'answer 3',
                'origin_language' => [
                    'language_name' => 'Spanish',
                    'language_code' => 'es'
                ]
            ],
            [
                'title' => 'Title free text',
                'answer_text' => 'answer 6',
                'is_translated' => false,
                'answer_original_text' => 'answer 6',
                'origin_language' => [
                    'language_name' => 'Greek',
                    'language_code' => 'el'
                ]
            ],
            [
                'title' => 'Title free text',
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
