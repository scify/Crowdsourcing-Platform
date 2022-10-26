<?php

namespace App\Models\ViewModels\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponsesPerLanguage;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponseStatistics;
use Illuminate\Support\Facades\Auth;

class QuestionnaireStatistics {
    public Questionnaire $questionnaire;
    public bool|null $userCanPrintStatistics;
    public QuestionnaireResponseStatistics $questionnaireResponseStatistics;
    public QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage;
    public string|int|null $current_user_id;
    public bool|null $userCanAnnotateAnswers;
    public int $projectFilter;

    public function __construct(Questionnaire                     $questionnaire,
                                QuestionnaireResponseStatistics   $questionnaireResponseStatistics,
                                QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage,
                                bool                              $userCanPrintStatistics,
                                bool                              $userCanAnnotateAnswers,
                                int                               $projectFilter) {
        $this->questionnaire = $questionnaire;
        $this->current_user_id = Auth::check() ? Auth::id() : 0;
        $this->userCanPrintStatistics = $userCanPrintStatistics;
        $this->questionnaireResponseStatistics = $questionnaireResponseStatistics;
        $this->numberOfResponsesPerLanguage = $numberOfResponsesPerLanguage;
        $this->userCanAnnotateAnswers = $userCanAnnotateAnswers;
        $this->projectFilter = $projectFilter;
    }

    public function userCanViewFileTypeQuestionsStatistics(): int {
        return ($this->userCanAnnotateAnswers || $this->questionnaire->show_file_type_questions_to_statistics_page_audience) ? 1 : -1;
    }
}
