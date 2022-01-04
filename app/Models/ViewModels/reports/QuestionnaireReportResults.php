<?php

namespace App\Models\ViewModels\reports;


class QuestionnaireReportResults {

    public $responses;
    public $respondentsRows;
    public $questionnaireId;

    public function __construct($responses, $respondentsRows,$questionnaireId) {
        $this->responses = $responses;
        $this->respondentsRows = $respondentsRows;
        $this->questionnaireId =$questionnaireId;
    }

}
