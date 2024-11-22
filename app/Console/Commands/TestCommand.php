<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TestCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test {--filter= : Filter the tests to run} {--coverage : Enable test coverage} {--migrate : Run migrations} {--seed : Seed the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run tests with custom environment settings, migrations, and seeders';

    /**
     * Execute the console command.
     */
    public function handle() {
        // Set the environment
        putenv('APP_ENV=testing');
        putenv('DB_CONNECTION=sqlite_testing');

        // Run the migrations if the --migrate option is set
        if ($this->option('migrate')) {
            $databaseFilePath = storage_path('database_testing.sqlite');
            $this->info('Creating the testing database in ' . $databaseFilePath);
            file_put_contents($databaseFilePath, null);
            $this->info('Running the migrations for the testing database...');
            Artisan::call('migrate:fresh', [
                '--env' => 'testing',
                '--database' => 'sqlite_testing',
            ]);
        }

        // Run the seeders if the --seed option is set
        if ($this->option('seed')) {
            $this->info('Seeding the testing database...');
            Artisan::call('db:seed', [
                '--env' => 'testing',
                '--database' => 'sqlite_testing',
                '--class' => 'DatabaseSeeder',
            ]);
        }

        // Prepare the test command options
        $testOptions = [];

        if ($filter = $this->option('filter')) {
            $testOptions['--filter'] = $filter;
        }

        if ($this->option('coverage')) {
            $testOptions['--coverage'] = true;
        }

        // Clear inherited options to avoid conflicts
        $this->info('Running tests...');
        $this->unsetConflictOptions();

        Artisan::call('test', $testOptions);

        // Display the output of the test command
        $this->info(Artisan::output());

        return 0;
    }

    /**
     * Unset conflicting options to prevent inheritance.
     */
    protected function unsetConflictOptions() {
        // Manually unset conflicting options
        foreach (['--seed', '--migrate', '--filter', '--coverage'] as $option) {
            $index = array_search($option, $_SERVER['argv']);
            if ($index !== false) {
                unset($_SERVER['argv'][$index]);
            }
        }
    }
}
