<?php

namespace App\Models\ViewModels;

use App\Models\Questionnaire\Questionnaire;
use Illuminate\Support\Collection;

class CreateEditQuestionnaire {
    public $questionnaire;
    public $projects;
    public $languages;
    public $title;
    public $questionnaireStatisticsPageVisibilityLkp;
    public $translationMetaData;
    public $questionnaireFieldsTranslations;
    public $type;

    public function __construct(Questionnaire $questionnaire,
        Collection $projects,
        Collection $languages,
        string $title,
        Collection $questionnaireStatisticsPageVisibilityLkp,
        Collection $questionnaireFieldsTranslations) {
        $this->questionnaire = $questionnaire;
        $this->projects = $projects;
        $this->languages = $languages;
        $this->title = $title;
        $this->questionnaireStatisticsPageVisibilityLkp = $questionnaireStatisticsPageVisibilityLkp;
        $this->questionnaireFieldsTranslations = $questionnaireFieldsTranslations;
        $this->translationMetaData = [
            'title' => [
                'display_title' => 'Title (*)',
                'required' => true,
            ],
            'description' => [
                'display_title' => 'Description (*)',
                'required' => true,
            ],
        ];
    }
}
