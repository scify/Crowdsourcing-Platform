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
        $questionIDsForQuestionnaire = DB::select('select id, type from questionnaire_questions
                                                 where questionnaire_id = ' . $questionnaire->id .
                                                 ' and deleted_at is null');
        $statisticsPerQuestionnaire = array();
        foreach ($questionIDsForQuestionnaire as $key=>$question) {
            // separate for each type
            if ($question->type == 'radiogroup' || $question->type == 'checkbox') {
                $fixedTypeStatistics = $this->getStatisticsForFixedChoicesQuestion($question->id);
                $statisticsPerQuestionnaire[$key] = [
                    'question_id' => $question->id,
                    'question_title' => $fixedTypeStatistics[0]['title'],
                    'question_type' => 'fixed_choices',
                    'statistics' => array()
                ];
                // remove title/deleted_at and push to statistics for each answer
                foreach ($fixedTypeStatistics as $key2=>$answers) {
                    unset($answers['title']);
                    unset($answers['deleted_at']);
                    array_push($statisticsPerQuestionnaire[$key]['statistics'], $answers);
                }
            } elseif ($question->type == 'text' || $question->type == 'comment') {
                $freeTextTypeStatistics = $this->getStatisticsForFreeTextQuestion($question->id);
                $statisticsPerQuestionnaire[$key] = [
                    'question_id' => $question->id,
                    'question_title' => $fixedTypeStatistics[0]['title'],
                    'question_type' => 'free_text',
                    'statistics' => array()
                ];
                foreach ($freeTextTypeStatistics as $key2=>$answers) {
                    array_push($statisticsPerQuestionnaire[$key]['statistics'], $answers);
                }
            }
        }

        // dd($statisticsPerQuestionnaire);
        return $statisticsPerQuestionnaire;
    }

    private function getStatisticsForFixedChoicesQuestion(int $questionId) {
        $query = DB::select('
            select question as title, qpa.answer as answer_title, count(*) as num_responses, fixedchoices.deleted_at from
                   (select question, id, deleted_at, answer_id from
                           (select qra.question_id , qq.question, qq.id, qra.deleted_at, qra.answer_id from questionnaire_response_answers as qra
                           inner join questionnaire_questions as qq on qra.question_id = qq.id
                           order by qq.question)
                    as qu)
            as fixedchoices
            inner join questionnaire_possible_answers as qpa on answer_id = qpa.id
            where fixedchoices.id = ' . $questionId . ' and fixedchoices.deleted_at is null group by question, qpa.answer, fixedchoices.deleted_at;
        ');
        $query = collect($query)->map(function($x) { return (array) $x;} )->toArray();

        return $query;
    }

    protected function getStatisticsForFreeTextQuestion(int $questionId) {
        // TODO
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
