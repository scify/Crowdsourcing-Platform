<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Questionnaire;

use App\BusinessLogicLayer\CommentAnalyzer\ToxicityAnalyzerService;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseToxicityRepository;

class QuestionnaireResponseToxicityAnalyzer {
    public function __construct(protected QuestionnaireResponseManager $questionnaireResponseManager, protected ToxicityAnalyzerService $toxicityAnalyzerService, protected QuestionnaireResponseToxicityRepository $questionnaireResponseToxicityRepository, protected QuestionnaireRepository $questionnaireRepository, protected QuestionnaireResponseRepository $questionnaireResponseRepository) {}

    public function analyzeQuestionnaireResponse(int $questionnaire_response_id): void {
        $questionnaireResponse = $this->questionnaireResponseRepository->find($questionnaire_response_id);
        $questionnaire = $this->questionnaireRepository->find($questionnaireResponse->questionnaire_id);
        $freeTypeQuestions = $this->questionnaireResponseManager->getFreeTypeQuestionsFromQuestionnaireJSON($questionnaire->questionnaire_json);
        $responseAnswers = json_decode((string) $questionnaireResponse->response_json, true);
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
        return str_contains($questionName, '-Comment') || array_key_exists($questionName, $freeTypeQuestions)
            && is_string($answer) && ! in_array(trim($answer), ['', '0'], true);
    }
}
