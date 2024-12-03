<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\Repository\Questionnaire\QuestionnaireTranslationRepository;
use App\Utils\Translator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class QuestionnaireTranslator {
    protected Translator $translator;
    protected $textsToTranslate;
    protected array $translatableQuestionnaireFirstLevelContentIdentifiers;
    protected array $translatablePageFirstLevelContentIdentifiers;
    protected array $translatableQuestionFirstLevelContentIdentifiers;
    protected array $translatableQuestionSecondLevelContentIdentifiers;
    protected QuestionnaireTranslationRepository $questionnaireTranslationRepository;
    protected array $translatableQuestionThirdLevelContentIdentifiers;

    public function __construct(Translator $translator, QuestionnaireTranslationRepository $questionnaireTranslationRepository) {
        $this->translator = $translator;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
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
            'editText',
        ];
        $this->translatablePageFirstLevelContentIdentifiers = [
            'title',
            'description',
            'navigationTitle',
            'navigationDescription',
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
            'commentText',
            'label',
            'labelTrue',
            'labelFalse',
            'optionsCaption',
            'keyDuplicationError',
            'totalText',
        ];
        $this->translatableQuestionSecondLevelContentIdentifiers = [
            'choices',
            'columns',
            'rows',
            'optionsCaption',
            'keyDuplicationError',
            'confirmDeleteText',
            'addRowText',
            'removeRowText',
            'emptyRowsText',
            'totalText',
            'requiredErrorText',
        ];
        $this->translatableQuestionThirdLevelContentIdentifiers = [
            'text',
            'title',
            'keyDuplicationError',
            'requiredErrorText',
            'optionsCaption',
            'totalFormat',
            'description',
            'commentText',
            'otherPlaceHolder',
            'noneText',
            'otherText',
            'totalText',
            'otherErrorText',
            'optionsCaption',
        ];
    }

    public function translateQuestionnaireJSONToLocales(string $json, array $locales): string {
        $translatedJSON = $json;
        foreach ($locales as $locale) {
            if (!empty($locale)) {
                $translatedJSON = $this->translateQuestionnaireJSONToLocale($translatedJSON, $locale);
            }
        }

        return $translatedJSON;
    }

    /**
     * @throws \Exception
     */
    public function translateQuestionnaireJSONToLocale(string $json, string $locale): string {
        if (empty($locale)) {
            return '';
        }
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
                            if (isset($question[$identifier][$i])
                                && is_array($question[$identifier][$i])) {
                                foreach ($this->translatableQuestionThirdLevelContentIdentifiers as $thirdLevelIdentifier) {
                                    $translatedSchema = $this->getContentTranslatedSchema(
                                        $question[$identifier][$i],
                                        $locale,
                                        $translationIndex,
                                        $thirdLevelIdentifier);
                                    if ($translatedSchema) {
                                        $question[$identifier][$i][$thirdLevelIdentifier] = $translatedSchema;
                                        $translationIndex++;
                                    }
                                }
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
                && array_key_exists($locale, $questionnaire[$identifier])
                && is_int($questionnaire[$identifier][$locale])) {
                $questionnaire[$identifier][$locale] = $translatedTexts[$questionnaire[$identifier][$locale]]['text'];
            }
        }

        for ($pageIndex = 0; $pageIndex < count($questionnaire['pages']); $pageIndex++) {
            foreach ($this->translatablePageFirstLevelContentIdentifiers as $identifier) {
                if (isset($questionnaire['pages'][$pageIndex][$identifier]) &&
                    is_array($questionnaire['pages'][$pageIndex][$identifier])
                    && array_key_exists($locale, $questionnaire['pages'][$pageIndex][$identifier])
                    && is_int($questionnaire['pages'][$pageIndex][$identifier][$locale])) {
                    $questionnaire['pages'][$pageIndex][$identifier][$locale] = $translatedTexts[$questionnaire['pages'][$pageIndex][$identifier][$locale]]['text'];
                }
            }

            for ($questionIndex = 0; $questionIndex < count($questionnaire['pages'][$pageIndex]['elements']); $questionIndex++) {
                $question = $questionnaire['pages'][$pageIndex]['elements'][$questionIndex];
                foreach ($this->translatableQuestionFirstLevelContentIdentifiers as $identifier) {
                    if (isset($question[$identifier]) &&
                        is_array($question[$identifier])
                        && array_key_exists($locale, $question[$identifier])
                        && is_int($question[$identifier][$locale])) {
                        $question[$identifier][$locale] = $translatedTexts[$question[$identifier][$locale]]['text'];
                        $questionnaire['pages'][$pageIndex]['elements'][$questionIndex] = $question;
                    }
                }
                foreach ($this->translatableQuestionSecondLevelContentIdentifiers as $identifier) {
                    if (isset($question[$identifier]) && is_array($question[$identifier])) {
                        for ($i = 0; $i < count($question[$identifier]); $i++) {
                            if (isset($question[$identifier][$i])
                                && is_array($question[$identifier][$i])) {
                                foreach ($this->translatableQuestionThirdLevelContentIdentifiers as $thirdLevelIdentifier) {
                                    if (isset($question[$identifier][$i][$thirdLevelIdentifier])
                                        && array_key_exists($locale, $question[$identifier][$i][$thirdLevelIdentifier])
                                        && is_int($question[$identifier][$i][$thirdLevelIdentifier][$locale])) {
                                        $question[$identifier][$i][$thirdLevelIdentifier][$locale] = $translatedTexts[$question[$identifier][$i][$thirdLevelIdentifier][$locale]]['text'];
                                        $questionnaire['pages'][$pageIndex]['elements'][$questionIndex] = $question;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $questionnaire;
    }

    protected function getContentTranslatedSchema(array $object, string $locale,
        int $translationIndex,
        string $contentIdentifier) {
        if (!isset($object[$contentIdentifier])) {
            return false;
        }
        $content = $object[$contentIdentifier];
        if (is_array($content)) {
            if (!array_key_exists($locale, $content) || (isset($content[$locale]) && trim($content[$locale]) === '')) {
                $this->textsToTranslate[] = $content['default'];
                $content[$locale] = $translationIndex;
            } else {
                return false;
            }
        } else {
            $this->textsToTranslate[] = $object[$contentIdentifier];
            $content = [
                'default' => $object[$contentIdentifier],
                $locale => $translationIndex,
            ];
        }

        return $content;
    }

    protected function identifierRefersToInnerChoices(string $identifier): bool {
        return in_array($identifier, ['choices', 'rows', 'columns']);
    }

    public function markQuestionnaireTranslations(int $questionnaireId, array $lang_ids_to_status): bool {
        foreach ($lang_ids_to_status as $lang_id_with_status) {
            $questionnaireLanguage = $this->questionnaireTranslationRepository->getQuestionnaireLanguage($questionnaireId, $lang_id_with_status['id']);
            if (!$questionnaireLanguage) {
                $lang_id = $lang_id_with_status['id'];
                throw new ResourceNotFoundException('Questionnaire Language not found. Questionnaire Id: ' . $questionnaireId . ' Lang id: ' . $lang_id);
            }
            $questionnaireLanguage->human_approved = $lang_id_with_status['status'];
            $questionnaireLanguage->save();
        }

        return true;
    }
}
