<?php

namespace Feature\Controllers\Solution;

use Tests\TestCase;

class SolutionControllerTest extends TestCase {
    /**
     * @test
     *
     * @group solution-controller-test
     *
     * Test Scenario 1:
     * GIVEN that a user is not authenticated,
     *
     * AND they try to access the solution propose page,
     * THEN they should be redirected to the login page.
     *
     * @return void
     */
    public function test_user_proposal_create_redirects_to_login_page_when_user_is_not_authenticated() {
        $response = $this->get('/en/project-slug/problems/problem-slug/solutions/propose');

        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }
}
