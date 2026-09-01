<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;

    // Every test runs inside a transaction that rolls back, so the seeded
    // test database stays pristine and test runs are repeatable without
    // re-running migrate:fresh --seed between them.
    use DatabaseTransactions;

    /**
     * Set the application environment for testing.
     */
    protected function setAppEnvironment(string $environment): void {
        // Simulate the environment mode
        putenv("APP_ENV=$environment");

        // Reload the app configuration to apply changes
        $this->app->detectEnvironment(fn (): string => $environment);
    }
}
