<?php

namespace App\Models\ViewModels;


class DashboardInfo
{
    public $project;
    public $badgesVM;
    public $gamificationNextStepVM;
    public $projectGoalVM;

    public function __construct($project,
                                GamificationBadgesWithLevels $badgesVM,
                                $gamificationNextStepViewModel,
                                $projectGoalVM) {
        $this->project = $this->formatProjectsInfoForDashboardDisplay($project);
        $this->badgesVM = $badgesVM;
        $this->gamificationNextStepVM = $gamificationNextStepViewModel;
        $this->projectGoalVM = $projectGoalVM;
    }

    private function formatProjectsInfoForDashboardDisplay($project)
    {
        $temp = (object)[
            'name' => $project->name,
            'slug' => '/' . $project->slug,
            'logo_path' => $project->logo_path,
            'help_by' => '-'
        ];
//        foreach ($project->questionnaires as $questionnaire) {
//            $statusHistory = $questionnaire->statusHistory->toArray();
//            $lastStatusHistoryItem = end($statusHistory);
//            $status = (object)$lastStatusHistoryItem['status'];
//            $temp->status = $status->title;
//
//        }

        return $temp;
    }
}