<?php

namespace Tests\Feature\Middleware;

use Tests\TestCase;

class EnforceDomainProtectionTest extends TestCase {
    /**
     * Test that a request from an allowed domain passes the middleware.
     */
    public function test_allows_request_from_allowed_domain(): void {
        // Simulate production environment
        $this->setAppEnvironment('production');

        // Make a request with an allowed Origin header
        $response = $this->withHeaders([
            'Origin' => config('app.url'),
        ])->getJson('/api/languages');

        // Assert the request is allowed (status code not forbidden)
        $response->assertStatus(200);
    }

    /**
     * Test that a request from a disallowed domain is blocked by the middleware.
     */
    public function test_blocks_request_from_disallowed_domain(): void {
        // Simulate production environment
        $this->setAppEnvironment('production');

        // Make a request with a disallowed Origin header
        $response = $this->withHeaders([
            'Origin' => 'https://malicious-domain.com',
        ])->getJson('/api/languages');

        // Assert the request is forbidden
        $response->assertStatus(403);
    }

    /**
     * Test that middleware does not block in non-production environments.
     */
    public function test_allows_all_domains_in_non_production(): void {
        // Simulate non-production environment
        $this->setAppEnvironment('local');

        // Make a request with any Origin header
        $response = $this->withHeaders([
            'Origin' => 'https://malicious-domain.com',
        ])->getJson('/api/languages');

        // Assert the request is allowed
        $response->assertStatus(200);
    }
}
