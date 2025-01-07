<?php

namespace App\ViewModels\Questionnaire\reports;

class QuestionnaireReportResults {
    public function __construct(public $responses, public $respondentsRows, public $questionnaireId, public $countResponses) {}
}
