<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/13/18
 * Time: 11:35 AM
 */

namespace App\Models\ViewModels;


class CrowdSourcingProjectForLandingPage
{
    public $project;
    public $questionnaire;
    public $questionnaireResponse;

    public function __construct($project, $questionnaire, $questionnaireResponse)
    {
        $this->project = $project;
        $this->questionnaire = $questionnaire;
        $this->questionnaireResponse = $questionnaireResponse;
    }
}