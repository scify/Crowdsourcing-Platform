<?php

namespace App\ViewModels\Questionnaire\reports;

use Illuminate\Support\Collection;

class QuestionnaireReportFilters {
    /**
     * @var \Illuminate\Support\Collection
     */
    public $allQuestionnaires;

    public function __construct(Collection $allQuestionnaires, public $selectedProjectId, public $selectedQuestionnaireId) {
        $this->allQuestionnaires = $allQuestionnaires;
    }
}
