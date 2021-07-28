<?php


namespace Database\Seeders;


use App\Models\Questionnaire\Questionnaire;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use Illuminate\Database\Seeder;

class CrowdSourcingProjectQuestionnairesSeeder extends Seeder {

    protected $crowdSourcingProjectQuestionnaireRepository;

    public function __construct(CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository) {
        $this->crowdSourcingProjectQuestionnaireRepository = $crowdSourcingProjectQuestionnaireRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $questionnaires = Questionnaire::withTrashed()->get();
        foreach ($questionnaires as $questionnaire) {
            $this->crowdSourcingProjectQuestionnaireRepository->addQuestionnaireToCrowdSourcingProject($questionnaire->id, $questionnaire->project_id);
        }
    }
}
