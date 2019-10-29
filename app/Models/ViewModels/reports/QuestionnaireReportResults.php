<?php

namespace App\Models\ViewModels\reports;


class QuestionnaireReportResults {

    public $usersRows;
    public $answersRows;
    public $respondentsRows;

    public function __construct($usersRows, $answersRows, $respondentsRows) {
        $this->usersRows = $usersRows;
        $this->answersRows = $answersRows;
        $this->respondentsRows = $respondentsRows;
    }

}
