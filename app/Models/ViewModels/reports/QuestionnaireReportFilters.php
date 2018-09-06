<?php

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class QuestionnaireReportFilters {

    public $selectedProjectId;
    public $selectedQuestionnaireId;
    public $allProjects;
    public $allQuestionnaires;

    public function __construct(Collection $allProjects, Collection $allQuestionnaires, $selectedProjectId, $selectedQuestionnaireId) {
        $this->allProjects = $allProjects;
        $this->allQuestionnaires = $allQuestionnaires;
        $this->selectedProjectId = $selectedProjectId;
        $this->selectedQuestionnaireId = $selectedQuestionnaireId;
    }

}