<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Utils\Translator;
use Illuminate\Support\Facades\Log;

class QuestionnaireResponseTranslator {
    protected QuestionnaireResponseRepository $questionnaireResponseRepository;
    protected QuestionnaireRepository $questionnaireRepository;
    protected QuestionnaireResponseManager $questionnaireResponseManager;
    protected Translator $translator;

    public function __construct(QuestionnaireResponseRepository $questionnaireResponseRepository,
        QuestionnaireRepository $questionnaireRepository,
        QuestionnaireResponseManager $questionnaireResponseManager,
        Translator $translator) {
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->translator = $translator;
    }

    public function translateFreeTextAnswersForQuestionnaireResponse(int $questionnaire_response_id) {
        $questionnaireResponse = $this->questionnaireResponseRepository->find($questionnaire_response_id);
        $questionnaire = $this->questionnaireRepository->find($questionnaireResponse->questionnaire_id);
        $freeTypeQuestions = $this->questionnaireResponseManager->getFreeTypeQuestionsFromQuestionnaireJSON($questionnaire->questionnaire_json);
        Log::info('Questionnaire response with id: ' . $questionnaire_response_id . ' has ' . count($freeTypeQuestions) . ' num of free text questions.');
        if (!count($freeTypeQuestions)) {
            $questionnaireResponse->response_json_translated = json_encode([]);
            $questionnaireResponse->save();

            return;
        }
        $responseAnswers = json_decode($questionnaireResponse->response_json, true);
        $textsToTranslate = [];
        $questionNamesToTranslate = [];
        foreach ($responseAnswers as $questionName => $answer) {
            if ($this->shouldTranslateAnswer($questionName, $answer, $freeTypeQuestions)) {
                array_push($textsToTranslate, $answer);
                array_push($questionNamesToTranslate, $questionName);
            }
        }
        Log::info('API Key: ' . config('app.google_translate_key'));
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
                $i++;
            }
        }
        $questionnaireResponse->response_json_translated = json_encode($responseAnswers);
        $questionnaireResponse->save();
    }

    protected function shouldAcceptTranslatedAnswer($answer,
        array $translations,
        int $i): bool {
        return strcmp(trim($translations[$i]['text']), trim($answer)) !== 0;
    }

    protected function shouldTranslateAnswer(string $questionName, $answer, array $freeTypeQuestions): bool {
        return strpos($questionName, '-Comment') !== false || array_key_exists($questionName, $freeTypeQuestions)
            && is_string($answer);
    }
}
