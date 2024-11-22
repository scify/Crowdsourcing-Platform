<?php

namespace App\Console\Commands;

use App\Models\User\User;
use App\Notifications\UserRegistered;
use App\Utils\Translator;
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

    /**
     * Execute the console command.
     */
    public function handle() {
        $task = $this->choice('Which task would you like to test?', ['Translate service', 'Test email', 'Test Sentry error']);

        if ($task === 'Translate service') {
            $this->info('Testing the translation service...');
            $texts = ['Hello', 'How are you?', 'Good morning'];
            $lang_code = 'fr';
            $translations = Translator::translateTexts($texts, $lang_code);
            $this->info('Translations:');
            foreach ($translations as $translation) {
                $this->info($translation);
            }
            $this->info('API Key: ' . config('app.google_translate_key'));
        } elseif ($task === 'Test email') {
            $this->info('Testing the email service...');
            $email = $this->ask('Enter the email address to send the test email to:');
            User::where(['email' => $email])->first()->notify(new UserRegistered);
            $this->info('The test email has been sent to ' . $email);
        } elseif ($task === 'Test Sentry error') {
            $this->info('Testing the Sentry error reporting service...');
            $message = $this->ask('Enter the message for the Sentry error:');
            throw new \Exception('Test Sentry error: ' . $message);
        }
    }
}
