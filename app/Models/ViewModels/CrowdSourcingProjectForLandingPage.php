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
    public $userResponse;
    public $allResponses;
    public $totalResponses;
    public $responsesNeededToReachGoal = 0;
    public $targetAchievedPercentage = 0;

    public function __construct($project, $questionnaire, $userResponse, $allResponses)
    {
        $this->project = $project;
        $this->questionnaire = $questionnaire;
        $this->userResponse = $userResponse;
        $this->allResponses = $allResponses;
        $this->totalResponses = $allResponses->count();
        if ($questionnaire) {
            $this->responsesNeededToReachGoal = $questionnaire->goal - $this->totalResponses;
            $this->targetAchievedPercentage = round($this->totalResponses / $questionnaire->goal * 100, 1);
        }
    }
}