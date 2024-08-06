<?php

namespace Database\Seeders;

use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Database\Seeder;

class QuestionnaireResponsesSeeder extends Seeder {
    private QuestionnaireResponseRepository $questionnaireResponseRepository;

    public function __construct(QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function run() {
        $questionnaireResponses = [
            ['id' => 1, 'questionnaire_id' => 1, 'project_id' => 1, 'user_id' => 1, 'language_id' => 6, 'response_json' => '{ "question2": "item1", "question3": "Lorem ipsum" }', 'response_json_translated' => '{ "question2": "item1", "question3": "Lorem ipsum" }'],
            ['id' => 2, 'questionnaire_id' => 2, 'project_id' => 2, 'user_id' => 1, 'language_id' => 6, 'response_json' => '{ "question2": "item1", "question3": "Lorem ipsum dolor sit amet" }', 'response_json_translated' => '{ "question2": "item1", "question3": "Lorem ipsum" }'],
            ['id' => 3, 'questionnaire_id' => 1, 'project_id' => 1, 'user_id' => 2, 'language_id' => 6, 'response_json' => '{ "question2": "item2", "question3": "Lorem ipsum dolor" }', 'response_json_translated' => '{ "question2": "item1", "question3": "Lorem ipsum" }'],
            ['id' => 4, 'questionnaire_id' => 2, 'project_id' => 2, 'user_id' => 2, 'language_id' => 6, 'response_json' => '{ "question2": "item1", "question3": "Lorem ipsum dolor" }', 'response_json_translated' => '{ "question2": "item1", "question3": "Lorem ipsum" }'],

        ];

        foreach ($questionnaireResponses as $questionnaireResponse) {
            $this->questionnaireResponseRepository->updateOrCreate(['id' => $questionnaireResponse['id']], $questionnaireResponse);
        }
    }
}
