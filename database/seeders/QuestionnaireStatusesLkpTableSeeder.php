<?php

namespace Database\Seeders;

use App\Models\Questionnaire\QuestionnaireStatus;
use Illuminate\Database\Seeder;

class QuestionnaireStatusesLkpTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $questionnaire_statuses_lkp = [
            ['id' => 1, 'title' => 'Draft', 'description' => 'The questionnaire is still under development.'],
            ['id' => 2, 'title' => 'Published', 'description' => 'The questionnaire is released and citizens can respond to it.'],
            ['id' => 3, 'title' => 'Finalized', 'description' => 'The questionnaire should not accept any new responses.'],
            ['id' => 4, 'title' => 'Unpublished', 'description' => 'The questionnaire is not available online anymore.'],
            ['id' => 5, 'title' => 'Deleted', 'description' => 'The questionnaire has been archived.'],
        ];

        foreach ($questionnaire_statuses_lkp as $questionnaire_status_lkp) {
            QuestionnaireStatus::updateOrCreate(
                ['id' => $questionnaire_status_lkp['id']],
                $questionnaire_status_lkp
            );
        }
    }
}
