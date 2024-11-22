<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * Indicates whether the seeder should be run before each test.
     * Defaults to false, meaning the seeder runs only once for the class.
     */
    protected bool $runSeederBeforeEachTest = false;

    /**
     * Refresh the in-memory database before each test.
     *
     * @return void
     */
    protected function refreshTestDatabase() {
        $databaseFilePath = storage_path('database_testing.sqlite');

        if (!RefreshDatabaseState::$migrated) {
            if (!File::exists($databaseFilePath)) {
                // Run the database migrations specific to testing
                echo "\nCreating the testing database...";
                $this->artisan('migrate:fresh', ['--env' => 'testing', '--database' => 'sqlite_testing']);
            }

            // Run the database seeds specific to testing
            echo "\nSeeding the testing database...";
            $this->artisan('db:seed', ['--env' => 'testing', '--database' => 'sqlite_testing', '--class' => 'DatabaseSeeder']);

            RefreshDatabaseState::$migrated = true;
        }

        if ($this->runSeederBeforeEachTest) {
            // Run the seeder again before each test, if specified
            echo "\nRunning the seeder before each test...";
            $this->artisan('db:seed', ['--env' => 'testing', '--database' => 'sqlite_testing', '--class' => 'DatabaseSeeder']);
        }

        $this->beginDatabaseTransaction();
    }
}
