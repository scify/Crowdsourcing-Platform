<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/9/18
 * Time: 4:40 PM
 */

namespace App\Models\ViewModels;


class DashboardInfo
{
    public $projects;
    public $badgesVM;
    public $gamificationNextStepVM;
    public $projectGoalVM;

    public function __construct($projects,
                                $responses,
                                GamificationBadgesWithLevels $badgesVM,
                                GamificationNextStep $gamificationNextStepViewModel,
                                CrowdSourcingProjectGoal $projectGoalVM) {
        $this->projects = $this->formatProjectsInfoForDashboardDisplay($projects, $responses);
        $this->badgesVM = $badgesVM;
        $this->gamificationNextStepVM = $gamificationNextStepViewModel;
        $this->projectGoalVM = $projectGoalVM;
    }

    private function formatProjectsInfoForDashboardDisplay($projects, $responses)
    {
        $results = collect([]);
        foreach ($projects as $project) {
            $temp = (object)[
                'name' => $project->name,
                'slug' => '/' . $project->slug,
                'logo_path' => $project->logo_path,
                'help_by' => '-'
            ];
            foreach ($project->questionnaires as $questionnaire) {
                $statusHistory = $questionnaire->statusHistory->toArray();
                $lastStatusHistoryItem = end($statusHistory);
                $status = (object)$lastStatusHistoryItem['status'];
                $temp->status = $status->title;

            }
            $results->push($temp);
        }
        return $results;
    }
}