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
    protected $signature = 'app:test {--filter=}';

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

        // create the testing database file (replace it if it already exists)
        $database_file_path = storage_path('database_testing.sqlite');
        $this->info('Creating the testing database in ' . $database_file_path);
        file_put_contents($database_file_path, null);

        // Run the migrations
        $this->info('Running the migrations for the testing database...');
        Artisan::call('migrate:fresh', ['--env' => 'testing', '--database' => 'sqlite_testing']);

        // Run the seeders
        $this->info('Seeding the testing database...');
        Artisan::call('db:seed', ['--env' => 'testing', '--database' => 'sqlite_testing', '--class' => 'DatabaseSeeder']);

        // Get the filter option
        $filter = $this->option('filter');

        // Run the tests
        $this->info('Running tests...');
        if ($filter) {
            Artisan::call('test', ['--filter' => $filter]);
        } else {
            Artisan::call('test');
        }

        return 0;
    }
}
