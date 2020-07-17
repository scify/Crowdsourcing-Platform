<?php

namespace App\Repository\QuestionnaireStatistics;

use Illuminate\Support\Facades\DB;

class QuestionnaireStatisticsRepository {

    // goal responses vs real responses
    public function getQuestionnaireResponseStatistics($questionnaireId) {
        $totalResponses = DB::select('select count(*) as count from questionnaire_responses where questionnaire_id = ' . $questionnaireId . ';');
        $goalResponses = DB::select('select goal from questionnaires where id = ' . $questionnaireId . ';');
        return new QuestionnaireResponseStatistics($totalResponses[0]->count, $goalResponses[0]->goal);
    }

    public function getNumberOfResponsesPerLanguage($questionnaireId) {
        $query = DB::select('SELECT count(*) as num_responses, language_code, language_name FROM ecas_local.questionnaire_responses as qr
                            join languages_lkp as ll on qr.language_id = ll.id
                            where questionnaire_id = ' . $questionnaireId . ' group by language_code;');

        return new QuestionnaireResponsesPerLanguage($query);
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
