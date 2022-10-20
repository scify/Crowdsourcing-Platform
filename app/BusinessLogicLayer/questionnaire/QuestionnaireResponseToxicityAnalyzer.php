<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\BusinessLogicLayer\CommentAnalyzer\ToxicityAnalyzerService;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseToxicityRepository;

class QuestionnaireResponseToxicityAnalyzer {
    protected $questionnaireResponseManager;
    protected $toxicityAnalyzerService;
    protected $questionnaireResponseToxicityRepository;
    protected $questionnaireRepository;
    protected $questionnaireResponseRepository;

    public function __construct(QuestionnaireResponseManager $questionnaireResponseManager,
                                ToxicityAnalyzerService $toxicityAnalyzerService,
                                QuestionnaireResponseToxicityRepository $questionnaireResponseToxicityRepository,
                                QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->toxicityAnalyzerService = $toxicityAnalyzerService;
        $this->questionnaireResponseToxicityRepository = $questionnaireResponseToxicityRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function analyzeQuestionnaireResponse(int $questionnaire_response_id) {
        $questionnaireResponse = $this->questionnaireResponseRepository->find($questionnaire_response_id);
        $questionnaire = $this->questionnaireRepository->find($questionnaireResponse->questionnaire_id);
        $freeTypeQuestions = $this->questionnaireResponseManager->getFreeTypeQuestionsFromQuestionnaireJSON($questionnaire->questionnaire_json);
        $responseAnswers = json_decode($questionnaireResponse->response_json, true);
        foreach ($responseAnswers as $questionName => $answer) {
            if ($this->shouldAnalyzeAnswer($questionName, $answer, $freeTypeQuestions)) {
                $toxicityResponse = $this->toxicityAnalyzerService->getToxicityScore($answer);
                $data = [
                    'questionnaire_response_id' => $questionnaireResponse->id,
                    'question_name' => $questionName,
                ];
                $this->questionnaireResponseToxicityRepository->updateOrCreate($data,
                    array_merge($data, [
                        'answer_text' => $answer,
                        'toxicity_score' => $toxicityResponse->toxicityScore,
                        'toxicity_api_response' => $toxicityResponse->toxicityAnalyzerResponse,
                    ]));
            }
        }
    }

    protected function shouldAnalyzeAnswer(string $questionName, $answer, array $freeTypeQuestions): bool {
        return strpos($questionName, '-Comment') !== false || array_key_exists($questionName, $freeTypeQuestions)
            && is_string($answer) && !empty(trim($answer));
    }
}
