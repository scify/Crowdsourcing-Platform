<?php

namespace App\ViewModels\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponsesPerLanguage;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponseStatistics;
use Illuminate\Support\Facades\Auth;

class QuestionnaireStatistics {
    public Questionnaire $questionnaire;
    public bool $userCanPrintStatistics;
    public QuestionnaireResponseStatistics $questionnaireResponseStatistics;
    public QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage;
    public $current_user_id;
    public bool $userCanAnnotateAnswers;
    public int $projectFilter;
    public array $projectColors;

    public function __construct(Questionnaire $questionnaire,
        QuestionnaireResponseStatistics $questionnaireResponseStatistics,
        QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage,
        bool $userCanPrintStatistics,
        bool $userCanAnnotateAnswers,
        int $projectFilter,
        array $projectColors = []) {
        $this->questionnaire = $questionnaire;
        $this->current_user_id = Auth::check() ? Auth::id() : 0;
        $this->userCanPrintStatistics = $userCanPrintStatistics;
        $this->questionnaireResponseStatistics = $questionnaireResponseStatistics;
        $this->numberOfResponsesPerLanguage = $numberOfResponsesPerLanguage;
        $this->userCanAnnotateAnswers = $userCanAnnotateAnswers;
        $this->projectFilter = $projectFilter;
        $this->projectColors = $projectColors;
    }

    public function userCanViewFileTypeQuestionsStatistics(): int {
        return ($this->userCanAnnotateAnswers || $this->questionnaire->show_file_type_questions_to_statistics_page_audience) ? 1 : -1;
    }

    public function projectHasExternalURL(): bool {
        return false;
    }

    public function projectHasCustomFooter(): bool {
        return false;
    }

    public function getProjectPrimaryColor(): string {
        return $this->projectColors['lp_primary_color'] ?? '#2b73fa';
    }

    public function getProjectBtnTextColor(): string {
        return (isset($this->projectColors['lp_btn_text_color_theme']) &&
        $this->projectColors['lp_btn_text_color_theme'] === 'light') ? '#ffffff' : '#212529';
    }
}
