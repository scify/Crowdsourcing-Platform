<?php

namespace App\Models\ViewModels;


use App\Models\Questionnaire;
use Illuminate\Support\Collection;

class CreateEditQuestionnaire
{
    public $questionnaire;
    public $projects;
    public $languages;
    public $title;
    public $maximumPrerequisiteOrder;
    public $questionnaireStatisticsPageVisibilityLkp;

    public function __construct(Questionnaire $questionnaire,
                                Collection $projects,
                                Collection $languages,
                                $title,
                                $maximumPrerequisiteOrder,
                                Collection $questionnaireStatisticsPageVisibilityLkp)
    {
        $this->questionnaire = $questionnaire;
        $this->projects = $projects;
        $this->languages = $languages;
        $this->title = $title;
        $this->maximumPrerequisiteOrder = $maximumPrerequisiteOrder;
        $this->questionnaireStatisticsPageVisibilityLkp = $questionnaireStatisticsPageVisibilityLkp;
    }

}
