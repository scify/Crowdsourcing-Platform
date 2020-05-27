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
        $textsToTranslate = $answerTexts->pluck('answer')->toArray();
        $translations = $this->translator->translateTexts($textsToTranslate, 'en');

        foreach ($translations as $index => $translation) {
            // get the model corresponding
            $answerTextModel = $answerTexts->get($index);
            $translatedText = $translation['text'];
            $source = $translation['source'];
            // only update the translation if the translation
            // is different from the original
            if ($translatedText && $translatedText != $answerTextModel->answer) {
                $translatedText = str_replace('&quot;', '"', $translatedText);
                $answerTextModel->english_translation = $translatedText;
                $answerTextModel->initial_language_detected = $source;
            }
            $answerTextModel->parsed = true;
            $answerTextModel->save();
        }
    }
}
