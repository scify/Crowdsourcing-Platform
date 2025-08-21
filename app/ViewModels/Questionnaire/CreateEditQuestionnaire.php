<?php

declare(strict_types=1);

namespace App\ViewModels\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use Illuminate\Support\Collection;

class CreateEditQuestionnaire {
    /**
     * @var \App\Models\Questionnaire\Questionnaire
     */
    public $questionnaire;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $projects;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $languages;

    /**
     * @var string
     */
    public $title;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $questionnaireStatisticsPageVisibilityLkp;

    public $translationMetaData = [
        'title' => [
            'display_title' => 'Title (*)',
            'required' => true,
        ],
        'description' => [
            'display_title' => 'Description (*)',
            'required' => true,
        ],
    ];

    /**
     * @var \Illuminate\Support\Collection
     */
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
    }
}
