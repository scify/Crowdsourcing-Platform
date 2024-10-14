<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\QuestionnaireTypeLkp;
use App\Models\Questionnaire\QuestionnaireType;
use Illuminate\Database\Seeder;

class QuestionnaireTypesSeeder extends Seeder {
    public function run() {
        $questionnaire_types = [
            ['id' => QuestionnaireTypeLkp::MAIN_QUESTIONNAIRE, 'name' => 'Main Questionnaire | The questionnaire the users are asked to respond for a project'],
            ['id' => QuestionnaireTypeLkp::FEEDBACK_QUESTIONNAIRE, 'name' => 'Feedback Questionnaire | The quality assessment questionnaire. User are invited to respond after they have responded to the Main questionnaire'],
        ];

        foreach ($questionnaire_types as $questionnaire_type) {
            QuestionnaireType::updateOrCreate(
                ['id' => $questionnaire_type['id']],
                $questionnaire_type
            );
        }
    }
}
