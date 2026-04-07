<?php

declare(strict_types=1);

namespace App\ViewModels\Questionnaire\reports;

use Illuminate\Support\Collection;

class QuestionnaireReportFilters {
    /**
     * @var Collection
     */
    public $allQuestionnaires;

    public function __construct(Collection $allQuestionnaires, public $selectedProjectId, public $selectedQuestionnaireId) {
        $this->allQuestionnaires = $allQuestionnaires;
    }
}
