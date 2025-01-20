<?php

namespace Unit\BusinessLogicLayer;

use App\BusinessLogicLayer\CookieManager;
use Illuminate\Support\Facades\Cookie;
use Mockery;
use Tests\TestCase;

class CookieManagerTest extends TestCase {
    protected function setUp(): void {
        parent::setUp();
        Cookie::shouldReceive('forget')->andReturnSelf();
    }

    protected function tearDown(): void {
        Mockery::close(); // Clear Mockery expectations
        parent::tearDown();
    }

    /**
     * @test
     *
     * @group cookie-manager
     *
     * GIVEN a cookie exists
     * WHEN deleteCookie is called
     * THEN the cookie should be deleted
     */
    public function delete_cookie_existing_cookie(): void {
        $_COOKIE['test_cookie'] = 'value';
        Cookie::shouldReceive('queue')->once()->with(Cookie::forget('test_cookie'));

        CookieManager::deleteCookie('test_cookie');

        $this->assertArrayNotHasKey('test_cookie', $_COOKIE);
    }

    /**
     * @test
     *
     * @group cookie-manager
     *
     * GIVEN a cookie does not exist
     * WHEN deleteCookie is called
     * THEN no error should occur
     */
    public function delete_cookie_non_existing_cookie(): void {
        Cookie::shouldReceive('queue')->once()->with(Cookie::forget('test_cookie'));

        CookieManager::deleteCookie('test_cookie');

        $this->assertArrayNotHasKey('test_cookie', $_COOKIE);
    }
}
