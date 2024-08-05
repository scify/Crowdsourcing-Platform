<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication, RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        // Run the database seeds specific to testing
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }
}
