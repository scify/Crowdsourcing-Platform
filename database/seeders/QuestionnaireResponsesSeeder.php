<?php

namespace Database\Seeders;

use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Database\Seeder;

class QuestionnaireResponsesSeeder extends Seeder {
    private QuestionnaireResponseRepository $questionnaireResponseRepository;

    public function __construct(QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function run(): void {
        $questionnaireResponses = [
            // Q1 — Climate Action Survey (project 1) — 5 responses
            [
                'id' => 1,
                'questionnaire_id' => 1,
                'project_id' => 1,
                'user_id' => 3,
                'language_id' => 6,
                'response_json' => '{"q1_urgency":5,"q2_priorities":["renewables","transport"],"q3_suggestion":"We need more cycle lanes urgently."}',
                'response_json_translated' => '{"q1_urgency":5,"q2_priorities":["renewables","transport"],"q3_suggestion":"We need more cycle lanes urgently."}',
            ],
            [
                'id' => 2,
                'questionnaire_id' => 1,
                'project_id' => 1,
                'user_id' => 4,
                'language_id' => 6,
                'response_json' => '{"q1_urgency":4,"q2_priorities":["greenspaces","waste"],"q3_suggestion":"Plant more trees and expand park areas."}',
                'response_json_translated' => '{"q1_urgency":4,"q2_priorities":["greenspaces","waste"],"q3_suggestion":"Plant more trees and expand park areas."}',
            ],
            [
                'id' => 3,
                'questionnaire_id' => 1,
                'project_id' => 1,
                'user_id' => 5,
                'language_id' => 6,
                'response_json' => '{"q1_urgency":5,"q2_priorities":["renewables","buildings","transport"],"q3_suggestion":"Subsidise home solar panels for all residents."}',
                'response_json_translated' => '{"q1_urgency":5,"q2_priorities":["renewables","buildings","transport"],"q3_suggestion":"Subsidise home solar panels for all residents."}',
            ],
            [
                'id' => 4,
                'questionnaire_id' => 1,
                'project_id' => 1,
                'user_id' => 1,
                'language_id' => 6,
                'response_json' => '{"q1_urgency":3,"q2_priorities":["transport"],"q3_suggestion":"Free public transport would make a big difference."}',
                'response_json_translated' => '{"q1_urgency":3,"q2_priorities":["transport"],"q3_suggestion":"Free public transport would make a big difference."}',
            ],
            [
                'id' => 5,
                'questionnaire_id' => 1,
                'project_id' => 1,
                'user_id' => 2,
                'language_id' => 6,
                'response_json' => '{"q1_urgency":4,"q2_priorities":["renewables","greenspaces"],"q3_suggestion":"Community energy cooperatives with shared ownership."}',
                'response_json_translated' => '{"q1_urgency":4,"q2_priorities":["renewables","greenspaces"],"q3_suggestion":"Community energy cooperatives with shared ownership."}',
            ],
            // Q2 — Digital Democracy (project 3) — 4 responses
            [
                'id' => 6,
                'questionnaire_id' => 2,
                'project_id' => 3,
                'user_id' => 3,
                'language_id' => 6,
                'response_json' => '{"q1_current_participation":"vote_only","q2_digital_tools":["mobile_app","online_voting"],"q3_barrier":"Lack of information on how to participate."}',
                'response_json_translated' => '{"q1_current_participation":"vote_only","q2_digital_tools":["mobile_app","online_voting"],"q3_barrier":"Lack of information on how to participate."}',
            ],
            [
                'id' => 7,
                'questionnaire_id' => 2,
                'project_id' => 3,
                'user_id' => 4,
                'language_id' => 6,
                'response_json' => '{"q1_current_participation":"online_petitions","q2_digital_tools":["open_data","forums"],"q3_barrier":"Distrust in whether my input makes a real difference."}',
                'response_json_translated' => '{"q1_current_participation":"online_petitions","q2_digital_tools":["open_data","forums"],"q3_barrier":"Distrust in whether my input makes a real difference."}',
            ],
            [
                'id' => 8,
                'questionnaire_id' => 2,
                'project_id' => 3,
                'user_id' => 5,
                'language_id' => 6,
                'response_json' => '{"q1_current_participation":"attend_meetings","q2_digital_tools":["mobile_app","forums"],"q3_barrier":"Meetings are held at inconvenient times."}',
                'response_json_translated' => '{"q1_current_participation":"attend_meetings","q2_digital_tools":["mobile_app","forums"],"q3_barrier":"Meetings are held at inconvenient times."}',
            ],
            [
                'id' => 9,
                'questionnaire_id' => 2,
                'project_id' => 3,
                'user_id' => 1,
                'language_id' => 6,
                'response_json' => '{"q1_current_participation":"not_at_all","q2_digital_tools":["online_voting"],"q3_barrier":"Too much complexity in government processes."}',
                'response_json_translated' => '{"q1_current_participation":"not_at_all","q2_digital_tools":["online_voting"],"q3_barrier":"Too much complexity in government processes."}',
            ],
            // Q3 — Smart Cities 2030 (project 4, finalized) — 3 responses
            [
                'id' => 10,
                'questionnaire_id' => 3,
                'project_id' => 4,
                'user_id' => 3,
                'language_id' => 6,
                'response_json' => '{"q1_smart_priority":"smart_transport","q2_readiness":3,"q3_concern":"Privacy and data surveillance."}',
                'response_json_translated' => '{"q1_smart_priority":"smart_transport","q2_readiness":3,"q3_concern":"Privacy and data surveillance."}',
            ],
            [
                'id' => 11,
                'questionnaire_id' => 3,
                'project_id' => 4,
                'user_id' => 4,
                'language_id' => 6,
                'response_json' => '{"q1_smart_priority":"smart_services","q2_readiness":2,"q3_concern":"Cost and equity — not everyone can afford smart tech."}',
                'response_json_translated' => '{"q1_smart_priority":"smart_services","q2_readiness":2,"q3_concern":"Cost and equity — not everyone can afford smart tech."}',
            ],
            [
                'id' => 12,
                'questionnaire_id' => 3,
                'project_id' => 4,
                'user_id' => 5,
                'language_id' => 6,
                'response_json' => '{"q1_smart_priority":"smart_energy","q2_readiness":4,"q3_concern":"Cybersecurity vulnerabilities in critical infrastructure."}',
                'response_json_translated' => '{"q1_smart_priority":"smart_energy","q2_readiness":4,"q3_concern":"Cybersecurity vulnerabilities in critical infrastructure."}',
            ],
        ];

        foreach ($questionnaireResponses as $questionnaireResponse) {
            $this->questionnaireResponseRepository->updateOrCreate(['id' => $questionnaireResponse['id']], $questionnaireResponse);
        }
    }
}
