<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\Utils\Translator;

class QuestionnaireTranslator {

    protected $translator;
    protected $textsToTranslate;
    protected $translatableQuestionnaireFirstLevelContentIdentifiers;
    protected $translatablePageFirstLevelContentIdentifiers;
    protected $translatableQuestionFirstLevelContentIdentifiers;
    protected $translatableQuestionSecondLevelContentIdentifiers;

    public function __construct(Translator $translator) {
        $this->translator = $translator;
        $this->translatableQuestionnaireFirstLevelContentIdentifiers = [
            'title',
            'description',
            'completedHtml',
            'completedBeforeHtml',
            'loadingHtml',
            'startSurveyText',
            'pagePrevText',
            'pageNextText',
            'completeText',
            'previewText',
            'editText'
        ];
        $this->translatablePageFirstLevelContentIdentifiers = [
            'title',
            'description',
            'navigationTitle',
            'navigationDescription'
        ];
        $this->translatableQuestionFirstLevelContentIdentifiers = [
            'title',
            'minRateDescription',
            'maxRateDescription',
            'requiredErrorText',
            'description',
            'minErrorText',
            'maxErrorText',
            'placeHolder',
            'otherPlaceHolder',
            'noneText',
            'otherText',
            'otherErrorText',
            'commentText'
        ];
        $this->translatableQuestionSecondLevelContentIdentifiers = [
            'choices',
            'columns',
            'rows'
        ];
    }

    public function translateQuestionnaireJSONToLocales(string $json, array $locales): string {
        $translatedJSON = $json;
        foreach ($locales as $locale)
            if (!empty($locale))
                $translatedJSON = $this->translateQuestionnaireJSONToLocale($translatedJSON, $locale);
        return $translatedJSON;
    }

    public function translateQuestionnaireJSONToLocale(string $json, string $locale): string {
        if (empty($locale))
            return "";
        $translationIndex = 0;
        $this->textsToTranslate = [];

        $questionnaire = json_decode($json, true);
        $questionnaire = $this->translateQuestionnaireFirstLevelAttributes($questionnaire, $locale, $translationIndex);
        $questionnaire = $this->translateQuestionnairePagesAndQuestions($questionnaire, $locale, $translationIndex);

        $translatedTexts = $this->translator->translateTexts($this->textsToTranslate, $locale);
        $questionnaire = $this->fillQuestionnaireWithTranslatedTexts($questionnaire, $locale, $translatedTexts);

        return json_encode($questionnaire);
    }

    protected function translateQuestionnaireFirstLevelAttributes(array $questionnaire, string $locale, int $translationIndex): array {
        foreach ($this->translatableQuestionnaireFirstLevelContentIdentifiers as $identifier) {
            $translatedSchema = $this->getContentTranslatedSchema(
                $questionnaire,
                $locale,
                $translationIndex,
                $identifier);
            if ($translatedSchema) {
                $questionnaire[$identifier] = $translatedSchema;
                $translationIndex++;
            }
        }

        return $questionnaire;
    }

    protected function translateQuestionnairePagesAndQuestions(array $questionnaire, string $locale, int $translationIndex): array {
        for ($pageIndex = 0; $pageIndex < count($questionnaire['pages']); $pageIndex++) {

            foreach ($this->translatablePageFirstLevelContentIdentifiers as $identifier) {
                $translatedSchema = $this->getContentTranslatedSchema(
                    $questionnaire['pages'][$pageIndex],
                    $locale,
                    $translationIndex,
                    $identifier);
                if ($translatedSchema) {
                    $questionnaire['pages'][$pageIndex][$identifier] = $translatedSchema;
                    $translationIndex++;
                }
            }

            for ($questionIndex = 0; $questionIndex < count($questionnaire['pages'][$pageIndex]['elements']); $questionIndex++) {
                $question = $questionnaire['pages'][$pageIndex]['elements'][$questionIndex];
                foreach ($this->translatableQuestionFirstLevelContentIdentifiers as $identifier) {
                    $translatedSchema = $this->getContentTranslatedSchema(
                        $question,
                        $locale,
                        $translationIndex,
                        $identifier);
                    if ($translatedSchema) {
                        $question[$identifier] = $translatedSchema;
                        $translationIndex++;
                    }
                }
                foreach ($this->translatableQuestionSecondLevelContentIdentifiers as $identifier) {
                    if (isset($question[$identifier]) && is_array($question[$identifier])) {
                        for ($i = 0; $i < count($question[$identifier]); $i++) {
                            $translatedSchema = $this->getContentTranslatedSchema(
                                $question[$identifier][$i],
                                $locale,
                                $translationIndex,
                                'text');
                            if ($translatedSchema) {
                                $question[$identifier][$i]['text'] = $translatedSchema;
                                $translationIndex++;
                            }
                        }
                    }
                }
                $questionnaire['pages'][$pageIndex]['elements'][$questionIndex] = $question;
            }
        }
        return $questionnaire;
    }

    protected function fillQuestionnaireWithTranslatedTexts(array $questionnaire, string $locale, array $translatedTexts): array {
        foreach ($this->translatableQuestionnaireFirstLevelContentIdentifiers as $identifier) {
            if (isset($questionnaire[$identifier]) &&
                is_array($questionnaire[$identifier])
                && key_exists($locale, $questionnaire[$identifier])
                && is_int($questionnaire[$identifier][$locale])) {
                $questionnaire[$identifier][$locale] = $translatedTexts[$questionnaire[$identifier][$locale]]['text'];
            }
        }

        for ($pageIndex = 0; $pageIndex < count($questionnaire['pages']); $pageIndex++) {

            foreach ($this->translatablePageFirstLevelContentIdentifiers as $identifier) {
                if (isset($questionnaire['pages'][$pageIndex][$identifier]) &&
                    is_array($questionnaire['pages'][$pageIndex][$identifier])
                    && key_exists($locale, $questionnaire['pages'][$pageIndex][$identifier])
                    && is_int($questionnaire['pages'][$pageIndex][$identifier][$locale])) {
                    $questionnaire['pages'][$pageIndex][$identifier][$locale] = $translatedTexts[$questionnaire['pages'][$pageIndex][$identifier][$locale]]['text'];
                }
            }

            for ($questionIndex = 0; $questionIndex < count($questionnaire['pages'][$pageIndex]['elements']); $questionIndex++) {
                $question = $questionnaire['pages'][$pageIndex]['elements'][$questionIndex];
                foreach ($this->translatableQuestionFirstLevelContentIdentifiers as $identifier) {
                    if (isset($question[$identifier]) &&
                        is_array($question[$identifier])
                        && key_exists($locale, $question[$identifier])
                        && is_int($question[$identifier][$locale])) {
                        $question[$identifier][$locale] = $translatedTexts[$question[$identifier][$locale]]['text'];
                        $questionnaire['pages'][$pageIndex]['elements'][$questionIndex] = $question;
                    }
                }
                foreach ($this->translatableQuestionSecondLevelContentIdentifiers as $identifier) {
                    if (isset($question[$identifier]) && is_array($question[$identifier])) {
                        for ($i = 0; $i < count($question[$identifier]); $i++) {
                            if (key_exists($locale, $question[$identifier][$i]['text'])
                                && is_int($question[$identifier][$i]['text'][$locale])) {
                                $question[$identifier][$i]['text'][$locale] = $translatedTexts[$question[$identifier][$i]['text'][$locale]]['text'];
                                $questionnaire['pages'][$pageIndex]['elements'][$questionIndex] = $question;
                            }
                        }
                    }

                }
            }
        }
        return $questionnaire;
    }

    protected
    function getContentTranslatedSchema(array  $object, string $locale,
                                        int    $translationIndex,
                                        string $contentIdentifier) {
        if (!isset($object[$contentIdentifier]))
            return false;
        $content = $object[$contentIdentifier];
        if (is_array($content)) {
            if (!key_exists($locale, $content) || (isset($content[$locale]) && trim($content[$locale]) === "")) {
                array_push($this->textsToTranslate, $content['default']);
                $content[$locale] = $translationIndex;
            } else
                return false;
        } else {
            array_push($this->textsToTranslate, $object[$contentIdentifier]);
            $content = [
                'default' => $object[$contentIdentifier],
                $locale => $translationIndex
            ];
        }
        return $content;
    }

    protected
    function identifierRefersToInnerChoices(string $identifier): bool {
        return in_array($identifier, ['choices', 'rows', 'columns']);
    }
}
