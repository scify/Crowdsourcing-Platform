<?php

namespace App\Models\ViewModels;


use App\Models\Questionnaire\Questionnaire;
use Illuminate\Support\Collection;

class CreateEditQuestionnaire
{
    public $questionnaire;
    public $projects;
    public $languages;
    public $title;
    public $questionnaireStatisticsPageVisibilityLkp;

    public function __construct(Questionnaire $questionnaire,
                                Collection $projects,
                                Collection $languages,
                                $title,
                                Collection $questionnaireStatisticsPageVisibilityLkp)
    {
        $this->questionnaire = $questionnaire;
        $this->projects = $projects;
        $this->languages = $languages;
        $this->title = $title;
        $this->questionnaireStatisticsPageVisibilityLkp = $questionnaireStatisticsPageVisibilityLkp;
    }

}
