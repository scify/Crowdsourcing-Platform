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
    protected $selectedLanguageId;

    public function __construct(Questionnaire $questionnaire, Collection $projects, Collection $languages, $title)
    {
        $this->questionnaire = $questionnaire;
        $this->projects = $projects;
        $this->languages = $languages;
        $this->title = $title;
        if($this->questionnaire->id)
            $this->selectedLanguageId = $this->questionnaire->default_language_id;
        else
            $this->selectedLanguageId = 6;
    }

    public function shouldLanguageBeSelected(Language $language) {
        return $this->selectedLanguageId === $language->id;
    }
}
