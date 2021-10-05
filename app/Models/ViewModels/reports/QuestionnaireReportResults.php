<?php

namespace App\Models\ViewModels\reports;


class QuestionnaireReportResults {

    public $responses;
    public $respondentsRows;

    public function __construct($responses, $respondentsRows) {
        $this->responses = $responses;
        $this->respondentsRows = $respondentsRows;
    }

}
