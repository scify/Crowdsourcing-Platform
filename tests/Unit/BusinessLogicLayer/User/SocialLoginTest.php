<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessLogicLayer\User;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\BusinessLogicLayer\User\UserManager;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\User\User;
use App\Models\User\UserRole;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Two\User as SocialUser;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SocialLoginTest extends TestCase {
    protected function setUp(): void {
        parent::setUp();
        Notification::fake();
    }

    /**
     * GIVEN an admin account
     * WHEN the admin logs in with a social provider that returns the same email
     * THEN the admin is logged in and keeps the admin role and the profile
     */
    #[Test]
    public function social_login_of_existing_account_keeps_roles_and_profile(): void {
        $admin = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create(['nickname' => 'Admin nickname', 'country' => 'Greece']);

        $user = app(UserManager::class)->handleSocialLoginUser($this->socialUser($admin->email));

        $this->assertSame($admin->id, $user->id);
        $this->assertAuthenticatedAs($admin);
        $admin->refresh();
        $this->assertTrue(app(UserRoleManager::class)->userHasAdminRole($admin));
        $this->assertSame('Admin nickname', $admin->nickname);
        $this->assertSame('Greece', $admin->country);
    }

    /**
     * GIVEN no account with the email of the social user
     * WHEN the user logs in with the social provider
     * THEN a registered user account is created
     */
    #[Test]
    public function social_login_creates_a_registered_user_for_a_new_email(): void {
        $user = app(UserManager::class)->handleSocialLoginUser($this->socialUser('new-social-user@example.com'));

        $this->assertSame('new-social-user@example.com', $user->email);
        $this->assertTrue(app(UserRoleManager::class)->userHasRegisteredUserRole($user));
        $this->assertAuthenticatedAs($user);
    }

    private function socialUser(string $email): SocialUser {
        return (new SocialUser)->map([
            'id' => '1234567890',
            'name' => 'Provider Name',
            'email' => $email,
            'avatar' => 'https://example.com/avatar.png',
        ]);
    }
}
