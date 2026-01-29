<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\CrowdSourcingProjectQuestionnaire;
use App\Models\Problem\Problem;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\Solution\Solution;
use App\Models\Solution\SolutionUpvote;
use App\Models\User\User;
use App\Notifications\Contracts\CampaignNotificationInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class NotifyCampaignResponders extends Command {
    /**
     * The name and signature of the console command.
     * Usage example: php artisan app:notify-campaign-responders 123 'App\Notifications\NotifyProjectEnded' hr --email=john@example.com
     *
     * @var string
     */
    protected $signature = 'app:notify-campaign-responders
                            {project_id : The ID of the project/campaign}
                            {notification_class : The fully-qualified notification class name (must implement CampaignNotificationInterface)}
                            {locale : The locale code for the notification (e.g., en, hr, de)}
                            {--email= : If provided, send notification only to this email address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification to all unique users who contributed to a project (questionnaire responders, solution creators, solution upvoters).';

    /**
     * Execute the console command.
     */
    public function handle(): int {
        $projectId = $this->argument('project_id');
        $notificationClass = $this->argument('notification_class');
        $locale = $this->argument('locale');
        $emailFilter = $this->option('email');

        // Validate the notification class
        if (! $this->validateNotificationClass($notificationClass)) {
            return self::FAILURE;
        }

        // Get the project
        $project = CrowdSourcingProject::find($projectId);
        if (! $project) {
            $this->error('Project not found.');

            return self::FAILURE;
        }

        $projectName = $project->defaultTranslation->name ?? $project->slug;

        // If email filter is provided, send only to that user
        if ($emailFilter) {
            return $this->sendToSingleUser($emailFilter, $projectName, $notificationClass, $locale);
        }

        return $this->sendToAllContributors($project, $projectName, $notificationClass, $locale);
    }

    /**
     * Send notification to a single user by email.
     */
    protected function sendToSingleUser(string $email, string $projectName, string $notificationClass, string $locale): int {
        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error(sprintf('User with email "%s" not found.', $email));

            return self::FAILURE;
        }

        $user->notify(new $notificationClass($projectName, $locale));
        $this->info(sprintf('Notification sent to: %s in locale: %s.', $email, $locale));
        $this->info('Total notifications sent: 1.');

        return self::SUCCESS;
    }

    /**
     * Send notification to all project contributors.
     */
    protected function sendToAllContributors(CrowdSourcingProject $project, string $projectName, string $notificationClass, string $locale): int {
        $contributorIds = $this->getAllContributorIds($project);

        if ($contributorIds->isEmpty()) {
            $this->info('No contributors found for this project.');

            return self::SUCCESS;
        }

        // Filter out anonymous users
        $users = User::whereIn('id', $contributorIds)
            ->where('email', 'not like', '%Anonymous_User_%')
            ->get();

        $notificationsSent = 0;
        foreach ($users as $user) {
            // $user->notify(new $notificationClass($projectName, $locale));
            $this->info(sprintf('Notification sent to: %s in locale: %s.', $user->email, $locale));
            ++$notificationsSent;
        }

        $this->info(sprintf('Total notifications sent: %d.', $notificationsSent));

        return self::SUCCESS;
    }

    /**
     * Get all unique contributor IDs for a project.
     */
    protected function getAllContributorIds(CrowdSourcingProject $project): Collection {
        $projectId = $project->id;

        // 1. Users who answered questionnaires
        $questionnaireIds = CrowdSourcingProjectQuestionnaire::where('project_id', $projectId)
            ->pluck('questionnaire_id');

        $questionnaireResponderIds = QuestionnaireResponse::whereIn('questionnaire_id', $questionnaireIds)
            ->where('project_id', $projectId)
            ->pluck('user_id');

        // 2. Users who created solutions (via problems belonging to this project)
        $problemIds = Problem::where('project_id', $projectId)->pluck('id');

        $solutionCreatorIds = Solution::whereIn('problem_id', $problemIds)
            ->whereNotNull('user_creator_id')
            ->pluck('user_creator_id');

        // 3. Users who upvoted solutions
        $solutionIds = Solution::whereIn('problem_id', $problemIds)->pluck('id');

        $solutionUpvoterIds = SolutionUpvote::whereIn('solution_id', $solutionIds)
            ->whereNotNull('user_voter_id')
            ->pluck('user_voter_id');

        // Combine and deduplicate
        return $questionnaireResponderIds
            ->merge($solutionCreatorIds)
            ->merge($solutionUpvoterIds)
            ->unique()
            ->values();
    }

    /**
     * Validate that the notification class exists and implements the required interface.
     */
    protected function validateNotificationClass(string $notificationClass): bool {
        if (! class_exists($notificationClass)) {
            $this->error(sprintf('Notification class "%s" does not exist.', $notificationClass));

            return false;
        }

        if (! is_a($notificationClass, CampaignNotificationInterface::class, true)) {
            $this->error(sprintf(
                'Notification class "%s" must implement %s.',
                $notificationClass,
                CampaignNotificationInterface::class
            ));

            return false;
        }

        return true;
    }
}
