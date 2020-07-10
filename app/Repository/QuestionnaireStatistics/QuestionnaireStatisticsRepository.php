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

    // return both fixed and freetext from last two functions
    public function getStatisticsPerQuestion($questionnaire) {
        $questionIDsForQuestionnaire = DB::select('select id from questionnaire_questions
                                                 where (type = "radiogroup" or type = "checkbox")
                                                 and questionnaire_id = ' . $questionnaire->id);
        $statisticsPerQuestionnaire = array();
        // $repliedQuestions = $this->getStatisticsForFixedChoicesQuestion($question->id);
        foreach ($questionIDsForQuestionnaire as $question) {
            $fullStatistics = $this->getStatisticsForFixedChoicesQuestion($question->id);
            $statisticsPerQuestionnaire[] = [
                'question_id' => $question->id,
                'question_title' => $fullStatistics[0]['title'],
                'question_type' => 'free_text',
                'statistics' => [
                    'answer_title' => $fullStatistics[0]['title'],
                    'num_responses' => $fullStatistics[0]['num_responses']
                ]
            ];
        }

        return $statisticsPerQuestionnaire;
    }

    // Get 'answer_title' (text) and 'num_responses' (int)
    private function getStatisticsForFixedChoicesQuestion(int $questionId) {
        $query = DB::select('
            select question as title, count(*) as num_responses from
                   (select question, id from
                           (select qra.question_id , qq.question, qq.id from questionnaire_response_answers as qra
                           inner join questionnaire_questions as qq on qra.question_id = qq.id
                           order by qq.question)
                    as qu)
            as fixedchoices where id = 494 group by question;
        ');

        $query = collect($query)->map(function($x) { return (array) $x;} )->toArray();

        if (count($query) > 0) {
            return $query;
        }
    }

    protected function getStatisticsForFreeTextQuestion(int $questionId) {
    }

}
