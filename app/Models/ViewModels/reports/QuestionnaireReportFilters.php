<?php

namespace App\Models\ViewModels\reports;

use Illuminate\Support\Collection;

class QuestionnaireReportFilters {
    public $selectedProjectId;
    public $selectedQuestionnaireId;
    public $allQuestionnaires;

    public function __construct(Collection $allQuestionnaires, $selectedProjectId, $selectedQuestionnaireId) {
        $this->allQuestionnaires = $allQuestionnaires;
        $this->selectedProjectId = $selectedProjectId;
        $this->selectedQuestionnaireId = $selectedQuestionnaireId;
    }
}
