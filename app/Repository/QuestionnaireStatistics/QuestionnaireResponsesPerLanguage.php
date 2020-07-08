<?php

namespace App\Repository\QuestionnaireStatistics;

class QuestionnaireResponsesPerLanguage {

    public $numberOfResponsesPerLanguage;

    public function __construct($numberOfResponsesPerLanguage) {
        $this->numberOfResponsesPerLanguage = $numberOfResponsesPerLanguage;
    }
   
}
