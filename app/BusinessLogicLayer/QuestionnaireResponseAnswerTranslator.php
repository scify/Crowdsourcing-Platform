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
            if($answerText) {
                $translation = $this->translator->translateTexts([$answerText->answer], 'en');
                $text = $translation[0]['text'];
                $source = $translation[0]['source'];
                if ($text && $text != $answerText->answer) {
                    $text = str_replace('&quot;', '"', $text);
                    $answerText->english_translation = $text;
                    $answerText->initial_language_detected = $source;
                    $answerText->save();
                }
            }
        }
    }
}
