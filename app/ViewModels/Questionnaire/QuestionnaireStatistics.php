<?php

namespace App\ViewModels\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponsesPerLanguage;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponseStatistics;
use Illuminate\Support\Facades\Auth;

class QuestionnaireStatistics {
    public $current_user_id;

    public function __construct(public Questionnaire $questionnaire,
        public QuestionnaireResponseStatistics $questionnaireResponseStatistics,
        public QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage,
        public bool $userCanPrintStatistics,
        public bool $userCanAnnotateAnswers,
        public int $projectFilter,
        public array $projectColors = []) {
        $this->current_user_id = Auth::check() ? Auth::id() : 0;
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
