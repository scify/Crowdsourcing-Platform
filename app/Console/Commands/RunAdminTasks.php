<?php

namespace App\Console\Commands;

use App\BusinessLogicLayer\Gamification\PlatformWideGamificationBadgesProvider;
use App\Jobs\TranslateQuestionnaireResponse;
use App\Models\Language;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User\User;
use App\Notifications\NotifyProjectPhaseChanged;
use App\Notifications\QuestionnaireResponded;
use App\Utils\Translator;
use App\ViewModels\Gamification\GamificationBadgeVM;
use Illuminate\Console\Command;

class RunAdminTasks extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-admin-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to test the availability of some tasks, like the external translation service and the emailing service.';

    private PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider;

    /**
     * Create a new command instance.
     */
    public function __construct(PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider) {
        parent::__construct();
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void {
        $task = $this->choice('Which task would you like to test?', ['Translate service', 'Test email', 'Test Sentry error', 'Test supervisor']);

        if ($task === 'Translate service') {
            $this->info('Testing the translation service...');
            $texts = ['Hello', 'How are you?', 'Good morning'];
            $lang_code = 'fr';
            $translations = Translator::translateTexts($texts, $lang_code);
            $this->info('Translations:');
            foreach ($translations as $translation) {
                $this->info($translation['input'] . ' => ' . $translation['text'] . ' => ' . $translation['source']);
            }
            $this->info('API Key: ' . config('app.google_translate_key'));
        } elseif ($task === 'Test email') {
            $this->info('Testing the email service...');
            $email = $this->ask('Enter the user email address to send the test email to:');
            $user = User::where(['email' => $email])->first();

            if (!$user) {
                $this->error('User not found with the given email address.');

                return;
            }

            $questionnaireId = $this->ask('Enter the questionnaire ID (0 for NotifyProjectPhaseChanged notification):');

            if ((int) $questionnaireId === 0) {
                $user->notify(new NotifyProjectPhaseChanged('Test Project', 'en'));
                $this->info('The NotifyProjectPhaseChanged notification has been sent to ' . $email);
            } else {
                $questionnaire = Questionnaire::find($questionnaireId);

                if (!$questionnaire) {
                    $this->error('Questionnaire not found with the given ID.');

                    return;
                }

                $language = $user->language ?? Language::where('language_code', 'en')->first();
                $badge = $this->platformWideGamificationBadgesProvider->getContributorBadge($user->id, 10);
                $badgeVM = new GamificationBadgeVM($badge);
                $projectTranslation = $questionnaire->projects->get(0)->translations->firstWhere('language_id', $language->id);
                $fieldsTranslation = $questionnaire->fieldsTranslations->firstWhere('language_id', $language->id);

                $user->notify(new QuestionnaireResponded(
                    $fieldsTranslation,
                    $badge,
                    $badgeVM,
                    $projectTranslation,
                    $language->language_code
                ));

                $this->info('The QuestionnaireResponded notification has been sent for questionnaire ID ' . $questionnaireId . ' to ' . $email);
            }
        } elseif ($task === 'Test Sentry error') {
            $this->info('Testing the Sentry error reporting service...');
            $message = $this->ask('Enter the message for the Sentry error:');
            throw new \Exception('Test Sentry error: ' . $message);
        } elseif ($task === 'Test supervisor') {
            $this->info('Testing the supervisor service...');
            $this->info('Supervisor version: ' . shell_exec('supervisord -v'));
            $this->info('Trying to send a test Questionnaire Response Translation event to supervisor...');
            $questionnaire_response = QuestionnaireResponse::first();
            $questionnaire_response->response_json_translated = null;
            $questionnaire_response->save();
            TranslateQuestionnaireResponse::dispatch($questionnaire_response->id);
            $this->info('The test Questionnaire Response Translation event has been sent to supervisor.');
        }
    }
}
