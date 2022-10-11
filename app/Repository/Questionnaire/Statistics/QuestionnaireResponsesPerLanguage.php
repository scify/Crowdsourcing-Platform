<?php

namespace App\Repository\Questionnaire\Statistics;

class QuestionnaireResponsesPerLanguage {
    public $data;

    public function __construct($data) {
        $this->data = $data;
    }
}
