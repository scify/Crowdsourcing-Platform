<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * Refresh the in-memory database before each test.
     *
     * @return void
     */
    protected function refreshTestDatabase() {
        if (!RefreshDatabaseState::$migrated) {
            // Run the database migrations specific to testing
            $this->artisan('migrate:fresh', ['--env' => 'testing', '--database' => 'sqlite_testing']);

            // Run the database seeds specific to testing
            $this->artisan('db:seed', ['--env' => 'testing', '--database' => 'sqlite_testing', '--class' => 'DatabaseSeeder']);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}
