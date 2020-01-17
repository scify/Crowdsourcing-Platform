<?php

namespace App\Models\ViewModels;


use App\Models\Language;
use App\Models\Questionnaire;
use Illuminate\Support\Collection;

class CreateEditQuestionnaire
{
    public $questionnaire;
    public $projects;
    public $languages;
    public $title;
    public $maximumPrerequisiteOrder;
    protected $selectedLanguageId;

    public function __construct(Questionnaire $questionnaire, Collection $projects, Collection $languages, $title, $maximumPrerequisiteOrder = null)
    {
        $this->questionnaire = $questionnaire;
        $this->projects = $projects;
        $this->languages = $languages;
        $this->title = $title;
        $this->maximumPrerequisiteOrder = $maximumPrerequisiteOrder;
        if($this->questionnaire->id)
            $this->selectedLanguageId = $this->questionnaire->default_language_id;
        else
            $this->selectedLanguageId = 6;
    }

    public function shouldLanguageBeSelected(Language $language) {
        return $this->selectedLanguageId === $language->id;
    }

    public function shouldPrerequisiteOrderBeSelected(int $index) {
        if($this->questionnaire->prerequisite_order)
            return $index === $this->questionnaire->prerequisite_order;
        return $index === $this->maximumPrerequisiteOrder;
    }
}
