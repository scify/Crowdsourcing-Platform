<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\Repository\LanguageRepository;
use App\Repository\Questionnaire\QuestionnaireFieldsTranslationRepository;
use App\Utils\Helpers;
use Illuminate\Support\Collection;

class QuestionnaireFieldsTranslationManager {
    protected $questionnaireFieldsTranslationRepository;
    protected $languageRepository;

    public function __construct(QuestionnaireFieldsTranslationRepository $questionnaireFieldsTranslationRepository,
        LanguageRepository $languageRepository) {
        $this->questionnaireFieldsTranslationRepository = $questionnaireFieldsTranslationRepository;
        $this->languageRepository = $languageRepository;
    }

    public function getFieldsTranslationForQuestionnaire(Questionnaire $questionnaire): QuestionnaireFieldsTranslation {
        $language = $this->languageRepository->where(['language_code' => app()->getLocale()]);
        if (!$language) {
            return $questionnaire->defaultFieldsTranslation;
        }
        $fieldsTranslation = $this->questionnaireFieldsTranslationRepository->where([
            'questionnaire_id' => $questionnaire->id,
            'language_id' => $language->id,
        ]);

        return $fieldsTranslation ?: $questionnaire->defaultFieldsTranslation;
    }

    public function getFieldsTranslationsForQuestionnaire(Questionnaire $questionnaire): Collection {
        if (!$questionnaire->id) {
            return new Collection();
        }

        return $this->questionnaireFieldsTranslationRepository->allWhere(['questionnaire_id' => $questionnaire->id]);
    }

    public function storeOrUpdateDefaultFieldsTranslationForQuestionnaire(array $attributes, int $questionnaire_id) {
        $allowedKeys = (new QuestionnaireFieldsTranslation())->getFillable();
        $filtered = Helpers::getFilteredAttributes($attributes, $allowedKeys);
        $this->questionnaireFieldsTranslationRepository->updateOrCreate(
            ['questionnaire_id' => $questionnaire_id, 'language_id' => $filtered['language_id']],
            $filtered
        );
    }

    public function storeOrUpdateFieldsTranslationsForQuestionnaire(array $attributesArray, int $questionnaire_id, int $language_id) {
        $defaultLanguageContentForProject = $this->questionnaireFieldsTranslationRepository->where([
            'questionnaire_id' => $questionnaire_id, 'language_id' => $language_id, ])
            ->toArray();
        $allowedKeys = (new QuestionnaireFieldsTranslation())->getFillable();
        foreach ($attributesArray as $attributes) {
            $attributes = json_decode(json_encode($attributes), true);
            foreach ($attributes as $key => $value) {
                if (!$value) {
                    $attributes[$key] = $defaultLanguageContentForProject[$key];
                }
            }
            $filtered = Helpers::getFilteredAttributes($attributes, $allowedKeys);
            $filtered['questionnaire_id'] = $questionnaire_id;
            $this->questionnaireFieldsTranslationRepository->updateOrCreate(
                ['questionnaire_id' => $questionnaire_id, 'language_id' => $filtered['language_id']],
                $filtered
            );
        }
    }
}
