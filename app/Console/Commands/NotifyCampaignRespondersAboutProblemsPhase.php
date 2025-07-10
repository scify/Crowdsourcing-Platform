<?php

namespace App\Console\Commands;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Language;
use App\Models\Questionnaire\Questionnaire;
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

        // Get all questionnaires for the project
        $questionnaireIds = Questionnaire::where('project_id', $projectId)->pluck('id');

        // Get all unique user/language pairs from responses to these questionnaires
        $responses = QuestionnaireResponse::whereIn('questionnaire_id', $questionnaireIds)
            ->select('user_id', 'language_id')
            ->distinct()
            ->get();

        // Eager load users and languages
        $userIds = $responses->pluck('user_id')->unique();
        $languageIds = $responses->pluck('language_id')->unique();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');
        $languages = Language::whereIn('id', $languageIds)->get()->keyBy('id');

        $project = CrowdSourcingProject::find($projectId);
        if (!$project) {
            $this->error('Project not found.');

            return;
        }
        $projectName = $project->defaultTranslation->name ?? $project->slug;

        // Print header
        $this->info("#\tUser Email\tLanguage");
        foreach ($responses as $i => $response) {
            $user = $users[$response->user_id] ?? null;

            $language = $languages[$response->language_id] ?? null;
            if (!$user || !$language) {
                continue;
            }
            $email = $user->email;
            $lang = $language->language_code;
            $this->line("#{$i}\t$email\t$lang");

            // Send notification
            // $user->notify(new NotifyProjectPhaseChanged($projectName, $lang));
        }
    }
}
