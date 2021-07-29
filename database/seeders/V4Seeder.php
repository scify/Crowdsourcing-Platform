<?php

namespace Database\Seeders;

use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use Illuminate\Database\Seeder;

class V4Seeder extends Seeder {

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
        $this->call([
            CrowdSourcingProjectColorsSeeder::class
        ]);

        $questionnaires = Questionnaire::withTrashed()->get();
        foreach ($questionnaires as $questionnaire) {
            $this->crowdSourcingProjectQuestionnaireRepository->addQuestionnaireToCrowdSourcingProject($questionnaire->id, $questionnaire->project_id);
        }

        // update all questionnaire responses to have a project_id
        $questionnaireResponses = QuestionnaireResponse::where(['project_id' => null])->get();
        foreach ($questionnaireResponses as $questionnaireResponse) {
            $projectId = $questionnaireResponse->questionnaire->projects->get(0)->id;
            $questionnaireResponse->project_id = $projectId;
            $questionnaireResponse->save();
        }
    }

}
