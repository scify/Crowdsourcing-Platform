<?php

namespace App\Models\ViewModels\reports;


class QuestionnaireReportResults {

    public $usersRows;
    public $answersRows;

    public function __construct($usersRows, $answersRows) {
        $this->usersRows = $usersRows;
        $this->answersRows = $answersRows;
    }

}