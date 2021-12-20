<?php

namespace Database\Seeders;

use App\Repository\Questionnaire\Responses\QuestionnaireAnswerAdminReviewLkpRepository;
use Illuminate\Database\Seeder;

class QuestionnaireAnswerAdminAnalysisLkpTableSeeder extends Seeder {

    protected $repository;

    public function __construct(QuestionnaireAnswerAdminReviewLkpRepository $repository) {
        $this->repository = $repository;
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
                'name' => 'Reviewed by moderator - no further action',
                'description' => 'The answer was reviewed by a moderator - no further action is needed.'
            ],
            [
                'id' => 2,
                'name' => 'Interesting / Useful',
                'description' => 'The answer was reviewed by a moderator and it was marked as a useful one.',
            ],
            [
                'id' => 3,
                'name' => 'Not useful - Display only when user clicks view all',
                'description' => 'The answer was reviewed by a moderator and it was marked as not useful.',
            ],
            [
                'id' => 4,
                'name' => 'Toxic - always hide answer',
                'description' => 'The answer was reviewed by a moderator and it was marked as toxic. It will never be shown in the statistics.',
            ]
        ];
        foreach ($data as $datum) {
            $this->repository->updateOrCreate(['id' => $datum['id']],
                [
                    'id' => $datum['id'],
                    'name' => $datum['name'],
                    'description' => $datum['description']
                ]
            );
            echo "\nAdded Questionnaire Annotation Answer Status: " . $datum['name'] . "\n";
        }
    }
}
