<?php

namespace App\Models\ViewModels\reports;


class QuestionnaireReportResults {

    public $usersRows;
    public $responses;
    public $respondentsRows;

    public function __construct($usersRows, $responses, $respondentsRows) {
        $this->usersRows = $usersRows;
        $this->responses = $responses;
        $this->respondentsRows = $respondentsRows;
    }

}
