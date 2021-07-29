<?php


namespace App\Models\ViewModels\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponsesPerLanguage;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponseStatistics;

class QuestionnaireStatistics {

    public $questionnaire;
    public $userCanPrintStatistics;
    public $questionnaireResponseStatistics;
    public $numberOfResponsesPerLanguage;

    public function __construct(Questionnaire $questionnaire,
                                QuestionnaireResponseStatistics $questionnaireResponseStatistics,
                                QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage,
                                $userCanPrintStatistics) {
        $this->questionnaire = $questionnaire;
        $this->userCanPrintStatistics = $userCanPrintStatistics;
        $this->questionnaireResponseStatistics = $questionnaireResponseStatistics;
        $this->numberOfResponsesPerLanguage = $numberOfResponsesPerLanguage;
    }

}
