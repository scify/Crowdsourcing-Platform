<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;

    /**
     * Set the application environment for testing.
     */
    protected function setAppEnvironment(string $environment): void {
        // Simulate the environment mode
        putenv("APP_ENV=$environment");

        // Reload the app configuration to apply changes
        $this->app->detectEnvironment(function () use ($environment) {
            return $environment;
        });
    }
}
