<?php

namespace App\ViewModels\Questionnaire\reports;

class QuestionnaireReportResults {
    public $responses;
    public $respondentsRows;
    public $questionnaireId;
    public $countResponses;

    public function __construct($responses, $respondentsRows, $questionnaireId, $reponsesCounts) {
        $this->responses = $responses;
        $this->respondentsRows = $respondentsRows;
        $this->questionnaireId = $questionnaireId;
        $this->countResponses = $reponsesCounts;
    }
}
