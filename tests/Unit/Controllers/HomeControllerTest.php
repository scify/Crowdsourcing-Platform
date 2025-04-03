<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\HomeController;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HomeControllerTest extends TestCase {
    /**
     * Test Scenario 1:
     * GIVEN that there is no referrer
     *
     * WHEN the getRedirectBackUrl method is called
     *
     * THEN it should return the home route
     */
    #[Test]
    public function test_get_redirect_back_url_no_referrer(): void {
        // Arrange
        $controller = $this->app->make(HomeController::class);
        request()->headers->set('referer', null);

        // Act
        $result = $controller->getRedirectBackUrl();

        // Assert
        $this->assertEquals(route('home', ['locale' => 'en']), $result);
    }

    /**
     * Test Scenario 2:
     * GIVEN that the referrer belongs to a different host
     *
     * WHEN the getRedirectBackUrl method is called
     *
     * THEN it should return the home route
     */
    #[Test]
    public function test_get_redirect_back_url_different_host(): void {
        // Arrange
        $controller = $this->app->make(HomeController::class);
        $referrer = 'https://external-website.com/some-page';
        request()->headers->set('referer', $referrer);

        // Act
        $result = $controller->getRedirectBackUrl();

        // Assert
        $this->assertEquals(route('home', ['locale' => 'en']), $result);
    }

    /**
     * Test Scenario 3:
     * GIVEN that the referrer is the project landing page
     * AND it does not contain the "?open" query string
     *
     * WHEN the getRedirectBackUrl method is called
     *
     * THEN it should append "?open=1" to the referrer URL
     */
    #[Test]
    public function test_get_redirect_back_url_project_landing_page_no_query(): void {
        // Arrange
        $controller = $this->app->make(HomeController::class);
        $referrer = route('project.landing-page', ['locale' => app()->getLocale(), 'slug' => 'test']);
        request()->headers->set('referer', $referrer);

        // Act
        $result = $controller->getRedirectBackUrl();

        // Assert
        $this->assertEquals($referrer . '?open=1', $result);
    }

    /**
     * Test Scenario 4:
     * GIVEN that the referrer is the project landing page
     * AND it already contains the "?open" query string
     *
     * WHEN the getRedirectBackUrl method is called
     *
     * THEN it should return the referrer URL as is
     */
    #[Test]
    public function test_get_redirect_back_url_project_landing_page_with_query(): void {
        // Arrange
        $controller = $this->app->make(HomeController::class);
        $referrer = route('project.landing-page', ['locale' => app()->getLocale(), 'slug' => 'test']) . '?open=1';
        request()->headers->set('referer', $referrer);

        // Act
        $result = $controller->getRedirectBackUrl();

        // Assert
        $this->assertEquals($referrer, $result);
    }
}
