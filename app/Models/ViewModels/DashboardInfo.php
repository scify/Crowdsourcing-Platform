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

    public function __construct($projects, $responses, GamificationBadgesWithLevels $badgesVM)
    {
        $this->projects = $this->formatProjectsInfoForDashboardDisplay($projects, $responses);
        $this->badgesVM = $badgesVM;
    }

    private function calculateDashboardHelpBySectionText($temp, $questionnaire, $responses)
    {
        $responseForQuestionnaire = $responses->where('questionnaire_id', $questionnaire->id)->first();
        if ($responseForQuestionnaire) // user has already responded
            return '-'; // TODO: we could propose to the user to invite others to respond to the questionnaire
        return '<a href="' . $temp->slug . '?open=1">Responding to a questionnaire</a>';
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
                if ($status->id === 2) { // questionnaire is published (HINT: we assume that only one questionnaire could be published at all times!)
                    $temp->help_by = $this->calculateDashboardHelpBySectionText($temp, $questionnaire, $responses);
                    break;
                }
            }
            $results->push($temp);
        }
        return $results;
    }
}