<?php

namespace Database\Seeders;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireLanguage;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireResponseAnswer;
use App\Models\QuestionnaireResponseAnswerText;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use Illuminate\Database\Seeder;

class V4Seeder extends Seeder {

    protected $crowdSourcingProjectQuestionnaireRepository;
    protected $questionnaireLanguageRepository;

    public function __construct(CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository,
                                QuestionnaireLanguageRepository             $questionnaireLanguageRepository) {
        $this->crowdSourcingProjectQuestionnaireRepository = $crowdSourcingProjectQuestionnaireRepository;
        $this->questionnaireLanguageRepository = $questionnaireLanguageRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // update colors for projects
        $this->call([
            CrowdSourcingProjectColorsSeeder::class
        ]);

        // project-questionnaire is a 1-to-many relationship now, so we should add each questionnaire to it's project
        $questionnaires = Questionnaire::withTrashed()->get();
        foreach ($questionnaires as $questionnaire) {
            $this->crowdSourcingProjectQuestionnaireRepository->addQuestionnaireToCrowdSourcingProject($questionnaire->id, $questionnaire->project_id);
        }

        // update all questionnaire responses to have a project_id
        $questionnaireResponses = QuestionnaireResponse::where(['project_id' => null])->get();
        foreach ($questionnaireResponses as $questionnaireResponse) {
            if ($questionnaireResponse->questionnaire) {
                $projectId = $questionnaireResponse->questionnaire->projects->get(0)->id;
            } else {
                $projectId = Questionnaire::withTrashed()->where('id', $questionnaireResponse->questionnaire_id)->first()->project_id;
            }
            $questionnaireResponse->project_id = $projectId;
            $questionnaireResponse->save();
        }

        // update all questionnaire languages to have the proper language_approved column value
        $questionnaireLanguages = QuestionnaireLanguage::all();
        foreach ($questionnaireLanguages as $questionnaireLanguage) {
            $questionnaireLanguage->human_approved = !$questionnaireLanguage->human_approved;
            $questionnaireLanguage->save();
        }


        $questionnaires = Questionnaire::all();
        foreach ($questionnaires as $questionnaire) {
            $data = [
                'questionnaire_id' => $questionnaire->id,
                'language_id' => $questionnaire->defaultLanguage->id
            ];
            $this->questionnaireLanguageRepository->updateOrCreate($data, $data);
        }

        $questionnaire_responses = QuestionnaireResponse::whereNull(['language_id'])->get();
        foreach ($questionnaire_responses as $questionnaire_response) {
            $questionnaire = Questionnaire::where(['id' => $questionnaire_response->questionnaire_id])->first();
            $questionnaire_response->language_id = $questionnaire->default_language_id;
            $questionnaire_response->save();
        }

        $this->transformQuestionnaireResponsesSchema();
        $this->call([
            UpdateResponsesWithRespondentIdSeeder::class
        ]);
        $defaultProject = CrowdSourcingProject::find(1);
        $defaultProject->img_path = '/storage/uploads/project_img/fair-eu-bg.png';
        $defaultProject->logo_path = '/storage/uploads/project_logos/fair-eu.png';
        $defaultProject->lp_questionnaire_img_path = '/storage/uploads/project_questionnaire_bg_img/bgsectionnaire.png';
        $defaultProject->sm_featured_img_path = '/storage/uploads/project_sm_featured_img/fair-eu.png';
        $defaultProject->save();

    }

    protected function transformQuestionnaireResponsesSchema() {
        // for each questionnaire, get all questions and all responses.
        // Then get all answers and all text-type answers.
        // Then update the questionnaire response in order to have the correct schema for the translated answer.

        $questionnaires = Questionnaire::all();
        $sum = 0;
        foreach ($questionnaires as $questionnaire) {
            $questions = QuestionnaireQuestion::where(['questionnaire_id' => $questionnaire->id])->get();
            $responses = QuestionnaireResponse::where(['questionnaire_id' => $questionnaire->id])->get();
            foreach ($responses as $response) {
                $responseObj = json_decode($response->response_json, true);
                $questionnaire_response_answers = QuestionnaireResponseAnswer::where(['questionnaire_response_id' => $response->id])->get();
                foreach ($responseObj as $question_name => $responseText) {
                    if (strpos($question_name, 'question') !== false && is_string($responseText)) {
                        $question = $questions->firstWhere('name', $question_name);
                        if ($question && ($question->type !== 'html')) {
                            $response_answer = $questionnaire_response_answers->firstWhere('question_id', $question->id);
                            if ($response_answer) {
                                $response_answer_text = QuestionnaireResponseAnswerText::
                                where(['questionnaire_response_answer_id' => $response_answer->id])
                                    ->first();
                                if ($response_answer_text
                                    && $response_answer_text->english_translation
                                    && $response_answer_text->initial_language_detected) {
                                    $original_answer = $response_answer_text->answer;
                                    $responseObj[$question_name] = [
                                        'initial_answer' => $original_answer,
                                        'translated_answer' => $response_answer_text->english_translation,
                                        'initial_language_detected' => $response_answer_text->initial_language_detected
                                    ];
                                    echo "\nParsed: " . $original_answer . " to: " . $response_answer_text->english_translation . " lang: " . $response_answer_text->initial_language_detected . "\n";
                                    $sum += 1;
                                } else {
                                    $responseObj[$question_name] = $responseText;
                                }
                                $response->response_json_translated = json_encode($responseObj);
                                $response->save();
                            }
                        }
                    }
                }
            }

        }
        echo "\n\n total: " . $sum . "\n\n";
    }
}
