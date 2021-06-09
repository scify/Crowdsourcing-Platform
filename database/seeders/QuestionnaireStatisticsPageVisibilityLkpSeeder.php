<?php

namespace Database\Seeders;

use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Statistics\QuestionnaireStatisticsPageVisibilityLkpRepository;
use Illuminate\Database\Seeder;

class QuestionnaireStatisticsPageVisibilityLkpSeeder extends Seeder {
    protected $questionnaireStatisticsPageVisibilityLkpRepository;
    protected $questionnaireRepository;

    public function __construct(QuestionnaireStatisticsPageVisibilityLkpRepository
                                $questionnaireStatisticsPageVisibilityLkpRepository,
                                QuestionnaireRepository $questionnaireRepository) {
        $this->questionnaireStatisticsPageVisibilityLkpRepository = $questionnaireStatisticsPageVisibilityLkpRepository;
        $this->questionnaireRepository = $questionnaireRepository;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'id' => 1,
                'title' => 'Public',
                'description' => 'The Statistics page is public to everyone'
            ],
            [
                'id' => 2,
                'title' => 'Respondents only',
                'description' => 'The Statistics page is accessible by those who have responded'
            ],
            [
                'id' => 3,
                'title' => 'Admins and Content Managers only',
                'description' => 'The Statistics page is accessible only by admins and content managers'
            ]
        ];

        foreach ($data as $datum) {
            $this->questionnaireStatisticsPageVisibilityLkpRepository->updateOrCreate([
                'id' => $datum['id']
            ], $datum);
        }

        // update all questionnaires that have null
        $questionnaires = $this->questionnaireRepository->where(['statistics_page_visibility_lkp_id' => null]);
        foreach ($questionnaires as $questionnaire) {
            $this->questionnaireRepository->update([
                'statistics_page_visibility_lkp_id' => 1
            ], $questionnaire->id);
            echo "\n" . "Questionnaire: " . $questionnaire->title . " updated.\n";
        }
    }
}
