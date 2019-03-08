<?php

namespace App\BusinessLogicLayer;


use App\Repository\QuestionnaireResponseAnswerRepository;
use App\Utils\Translator;

class QuestionnaireResponseAnswerTranslator {

    private $questionnaireResponseAnswerRepository;
    private $translator;

    public function __construct(QuestionnaireResponseAnswerRepository $questionnaireResponseAnswerRepository, Translator $translator) {
        $this->questionnaireResponseAnswerRepository = $questionnaireResponseAnswerRepository;
        $this->translator = $translator;
    }


    public function translateAllNonTranslatedAnswerTexts() {
        $answerTexts = $this->questionnaireResponseAnswerRepository->getNonTranslatedAnswers();
        foreach ($answerTexts as $answerText) {
            $translation = $this->translator->translateTexts([$answerText->answer], 'en');
            if(isset($translation[0]['text']) && $translation[0]['text'] != '' && $translation[0]['text'] != $answerText->answer) {
                $translation[0]['text'] = str_replace('&quot;', '"', $translation[0]['text']);
                $answerText->english_translation = $translation[0]['text'];
                $answerText->initial_language_detected = $translation[0]['source'];
                $answerText->save();
            }
        }
    }
}