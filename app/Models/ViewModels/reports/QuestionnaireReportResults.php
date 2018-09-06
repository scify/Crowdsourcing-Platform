<?php

namespace App\Models\ViewModels\reports;


class QuestionnaireReportResults {

    public $resultRows;

    public function __construct($resultRows) {
        $this->resultRows = $resultRows;
    }

}