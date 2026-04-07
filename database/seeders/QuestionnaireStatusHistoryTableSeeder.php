<?php

namespace Database\Seeders;

use App\Models\Questionnaire\QuestionnaireStatusHistory;
use Illuminate\Database\Seeder;

class QuestionnaireStatusHistoryTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $questionnaire_status_history = [
            ['id' => 1, 'questionnaire_id' => 1, 'status_id' => 1, 'comments' => 'Questionnaire is still under development.'],
            ['id' => 2, 'questionnaire_id' => 1, 'status_id' => 2, 'comments' => 'Questionnaire is released.'],
            ['id' => 3, 'questionnaire_id' => 2, 'status_id' => 1, 'comments' => 'Questionnaire is still under development.'],
            ['id' => 4, 'questionnaire_id' => 2, 'status_id' => 2, 'comments' => 'Questionnaire is released.'],
            ['id' => 5, 'questionnaire_id' => 3, 'status_id' => 1, 'comments' => 'Questionnaire under development.'],
            ['id' => 6, 'questionnaire_id' => 3, 'status_id' => 2, 'comments' => 'Questionnaire published and collecting responses.'],
            ['id' => 7, 'questionnaire_id' => 3, 'status_id' => 3, 'comments' => 'Campaign concluded. Questionnaire finalized after 187 responses.'],
        ];

        foreach ($questionnaire_status_history as $status_history) {
            QuestionnaireStatusHistory::updateOrCreate(['id' => $status_history['id']], $status_history);
        }
    }
}
