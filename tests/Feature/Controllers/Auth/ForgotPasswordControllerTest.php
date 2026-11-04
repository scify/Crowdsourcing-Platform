<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Auth;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User\User;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ForgotPasswordControllerTest extends TestCase {
    /**
     * GIVEN a password reset request with a forged Host header
     * WHEN the reset email is built
     * THEN the reset link uses the application URL, not the forged host
     */
    #[Test]
    public function reset_link_ignores_the_request_host(): void {
        Notification::fake();
        $user = User::factory()->create();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->withHeader('Host', 'evil.example')
            ->post('http://evil.example/en/password/email', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user): bool {
            $actionUrl = $notification->toMail($user)->actionUrl;

            return str_starts_with($actionUrl, rtrim((string) config('app.url'), '/') . '/')
                && ! str_contains($actionUrl, 'evil.example');
        });
    }
}
