<?php


namespace App\Models\ViewModels\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponsesPerLanguage;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponseStatistics;
use Illuminate\Support\Facades\Auth;

class QuestionnaireStatistics {

    public $questionnaire;
    public $userCanPrintStatistics;
    public $questionnaireResponseStatistics;
    public $numberOfResponsesPerLanguage;
    public $current_user_id;

    public function __construct(Questionnaire                     $questionnaire,
                                QuestionnaireResponseStatistics   $questionnaireResponseStatistics,
                                QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage,
                                                                  $userCanPrintStatistics) {
        $this->questionnaire = $questionnaire;
        $this->current_user_id = Auth::check() ? Auth::id() : 0;
        $this->userCanPrintStatistics = $userCanPrintStatistics;
        $this->questionnaireResponseStatistics = $questionnaireResponseStatistics;
        $this->numberOfResponsesPerLanguage = $numberOfResponsesPerLanguage;
    }

}
