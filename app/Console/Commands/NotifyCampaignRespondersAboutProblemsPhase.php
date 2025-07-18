<?php

namespace App\Console\Commands;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\CrowdSourcingProjectQuestionnaire;
use App\Models\Language;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User\User;
use App\Notifications\NotifyProjectPhaseChanged;
use Illuminate\Console\Command;

class NotifyCampaignRespondersAboutProblemsPhase extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-campaign-responders-about-problems-phase {project_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and print all unique users who responded to any questionnaire in a project, showing their email and response language.';

    /**
     * Execute the console command.
     */
    public function handle() {
        $projectId = $this->argument('project_id');

        // Get all questionnaires for the project from the intermediate table
        $questionnaireIds = CrowdSourcingProjectQuestionnaire::where('project_id', $projectId)->pluck('questionnaire_id');

        // Get all unique user/language pairs from responses to these questionnaires, filtered by project_id
        $responses = QuestionnaireResponse::whereIn('questionnaire_id', $questionnaireIds)
            ->where('project_id', $projectId)
            ->select('user_id', 'language_id')
            ->distinct()
            ->get();

        // Eager load users and languages
        $userIds = $responses->pluck('user_id')->unique();
        $languageIds = $responses->pluck('language_id')->unique();

        // Filter out users whose email contains 'Anonymous_User_'
        $users = User::whereIn('id', $userIds)
            ->where('email', 'not like', '%Anonymous_User_%')
            ->get()
            ->keyBy('id');
        $languages = Language::whereIn('id', $languageIds)->get()->keyBy('id');

        $project = CrowdSourcingProject::find($projectId);
        if (!$project) {
            $this->error('Project not found.');

            return;
        }
        $projectName = $project->defaultTranslation->name ?? $project->slug;

        // Print header
        $this->info("#\tUser Email\tLanguage");
        $i = 0;
        foreach ($responses as $response) {
            $user = $users[$response->user_id] ?? null;

            $language = $languages[$response->language_id] ?? null;
            if (!$user || !$language) {
                continue;
            }
            $i++;
            $email = $user->email;
            $lang = $language->language_code;
            $this->line("#{$i}\t$email\t$lang");

            // Send notification
            // $user->notify(new NotifyProjectPhaseChanged($projectName, $lang));
        }
    }
}
