<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Questionnaire;

use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Utils\Translator;

class QuestionnaireResponseTranslator {
    public function __construct(protected QuestionnaireResponseRepository $questionnaireResponseRepository, protected QuestionnaireRepository $questionnaireRepository, protected QuestionnaireResponseManager $questionnaireResponseManager, protected Translator $translator) {}

    public function translateFreeTextAnswersForQuestionnaireResponse(int $questionnaire_response_id): void {
        $questionnaireResponse = $this->questionnaireResponseRepository->find($questionnaire_response_id);
        $questionnaire = $this->questionnaireRepository->find($questionnaireResponse->questionnaire_id);
        $freeTypeQuestions = $this->questionnaireResponseManager->getFreeTypeQuestionsFromQuestionnaireJSON($questionnaire->questionnaire_json);
        if ($freeTypeQuestions === []) {
            $questionnaireResponse->response_json_translated = json_encode([]);
            $questionnaireResponse->save();

            return;
        }

        $responseAnswers = json_decode((string) $questionnaireResponse->response_json, true);
        $textsToTranslate = [];
        $questionNamesToTranslate = [];
        foreach ($responseAnswers as $questionName => $answer) {
            if ($this->shouldTranslateAnswer($questionName, $answer, $freeTypeQuestions)) {
                $textsToTranslate[] = $answer;
                $questionNamesToTranslate[] = $questionName;
            }
        }

        $translations = $this->translator->translateTexts($textsToTranslate, 'en');
        $i = 0;
        foreach ($responseAnswers as $questionName => $answer) {
            if ($this->shouldTranslateAnswer($questionName, $answer, $freeTypeQuestions)) {
                if ($this->shouldAcceptTranslatedAnswer($answer, $translations, $i)) {
                    $answerNewObj = [];
                    $answerNewObj['initial_answer'] = $answer;
                    $answerNewObj['translated_answer'] = $translations[$i]['text'];
                    $answerNewObj['initial_language_detected'] = $translations[$i]['source'];
                    $responseAnswers[$questionName] = $answerNewObj;
                }

                ++$i;
            }
        }

        $questionnaireResponse->response_json_translated = json_encode($responseAnswers);
        $questionnaireResponse->save();
    }

    protected function shouldAcceptTranslatedAnswer($answer,
        array $translations,
        int $i): bool {
        return strcmp(trim((string) $translations[$i]['text']), trim((string) $answer)) !== 0;
    }

    protected function shouldTranslateAnswer(string $questionName, $answer, array $freeTypeQuestions): bool {
        return str_contains($questionName, '-Comment') || array_key_exists($questionName, $freeTypeQuestions)
            && is_string($answer);
    }
}
