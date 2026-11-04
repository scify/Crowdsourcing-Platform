<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Auth;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class LoginControllerTest extends TestCase {
    public static function externalRedirectTargets(): array {
        return [
            'other host' => ['https://evil.example/phish'],
            'protocol-relative' => ['//evil.example/phish'],
            'backslash' => ['/\\evil.example/phish'],
            'javascript scheme' => ['javascript:alert(1)'],
        ];
    }

    /**
     * GIVEN a login link with a redirectTo value that leaves the application
     * WHEN the user logs in
     * THEN the user is sent to the dashboard instead
     */
    #[Test]
    #[DataProvider('externalRedirectTargets')]
    public function login_does_not_redirect_to_external_url(string $target): void {
        $user = User::factory()->create();

        $this->get(route('login', ['locale' => 'en']) . '?redirectTo=' . urlencode($target));
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post('/en/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($user);
        $this->assertStringNotContainsString('evil.example', (string) $response->headers->get('Location'));
        $this->assertStringNotContainsString('javascript:', (string) $response->headers->get('Location'));
    }

    /**
     * GIVEN a login link with a redirectTo value on the application host
     * WHEN the user logs in
     * THEN the user is sent to that URL
     */
    #[Test]
    public function login_redirects_to_url_on_application_host(): void {
        $user = User::factory()->create();
        $target = rtrim((string) config('app.url'), '/') . '/en/some-project';

        $this->get(route('login', ['locale' => 'en']) . '?redirectTo=' . urlencode($target));
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post('/en/login', ['email' => $user->email, 'password' => 'password']);

        $response->assertRedirect($target);
    }
}
