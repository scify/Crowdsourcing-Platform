<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Auth;

use App\BusinessLogicLayer\User\UserManager;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RegisterControllerTest extends TestCase {
    protected function setUp(): void {
        parent::setUp();
        Notification::fake();
    }

    /**
     * GIVEN valid user data
     * WHEN create method is called
     * THEN a new user should be created and assigned the registered user role
     */
    #[Test]
    public function create_user_with_valid_data(): void {
        $faker = Factory::create();
        $email = $faker->email;
        $data = [
            'nickname' => $faker->userName,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 'male',
            'country' => 'US',
            'year-of-birth' => 1990,
        ];

        $response = $this->post(route('register', ['locale' => 'en']), $data);

        $response->assertRedirect(route('my-dashboard'));
        $this->assertDatabaseHas('users', ['email' => $email]);
        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $user_role_manager = app()->make(UserRoleManager::class);
        $this->assertTrue($user_role_manager->userHasRegisteredUserRole($user));
    }

    /**
     * GIVEN user data with an existing email
     * WHEN create method is called
     * THEN the user should not be created and an error should be returned
     */
    #[Test]
    public function create_user_with_existing_email(): void {
        $faker = Factory::create();
        $email = $faker->email;
        User::factory()->create(['email' => $email]);

        $data = [
            'nickname' => 'testuser',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 'male',
            'country' => 'US',
            'year-of-birth' => 1990,
        ];

        $response = $this->post(route('register', ['locale' => 'en']), $data);

        $response->assertSessionHasErrors('email');
        $this->assertCount(1, User::where('email', $email)->get());
    }

    /**
     * GIVEN user data with invalid year of birth
     * WHEN create method is called
     * THEN the user should not be created and an error should be returned
     */
    #[Test]
    public function create_user_with_invalid_year_of_birth(): void {
        $data = [
            'nickname' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 'male',
            'country' => 'US',
            'year-of-birth' => now()->year - 10, // invalid year of birth (10 years old)
        ];

        $response = $this->post(route('register', ['locale' => 'en']), $data);

        $response->assertSessionHasErrors('year-of-birth');
        $this->assertDatabaseMissing('users', ['email' => 'testuser@example.com']);
    }

    /**
     * GIVEN user data with missing required fields
     * WHEN create method is called
     * THEN the user should not be created and errors should be returned
     */
    #[Test]
    public function create_user_with_missing_required_fields(): void {
        $data = [
            'nickname' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $response = $this->post(route('register', ['locale' => 'en']), $data);

        $response->assertSessionHasErrors(['nickname', 'email', 'password']);
        $this->assertDatabaseMissing('users', ['email' => '']);
    }

    /**
     * GIVEN an anonymous-user cookie that points to a registered account
     * WHEN a visitor registers
     * THEN a new account is created
     * AND the registered account is not changed
     */
    #[Test]
    public function register_with_cookie_of_a_registered_account_does_not_take_it_over(): void {
        $victim = User::factory()->create();
        $originalPasswordHash = $victim->password;

        $response = $this->withCookie(UserManager::$USER_COOKIE_KEY, (string) $victim->id)
            ->post(route('register', ['locale' => 'en']), $this->registrationData('attacker@example.com'));

        $response->assertRedirect(route('my-dashboard'));

        $victim->refresh();
        $this->assertNotSame('attacker@example.com', $victim->email);
        $this->assertSame($originalPasswordHash, $victim->password);
        $newUser = User::where('email', 'attacker@example.com')->firstOrFail();
        $this->assertNotSame($victim->id, $newUser->id);
        $this->assertAuthenticatedAs($newUser);
    }

    /**
     * GIVEN a forged plain-text anonymous-user cookie that points to a registered account
     * WHEN a visitor registers
     * THEN the registered account is not changed
     */
    #[Test]
    public function register_with_forged_plain_text_cookie_does_not_take_over_an_account(): void {
        $victim = User::factory()->create();
        $originalPasswordHash = $victim->password;

        $this->withUnencryptedCookie(UserManager::$USER_COOKIE_KEY, (string) $victim->id)
            ->post(route('register', ['locale' => 'en']), $this->registrationData('forger@example.com'));

        $victim->refresh();
        $this->assertNotSame('forger@example.com', $victim->email);
        $this->assertSame($originalPasswordHash, $victim->password);
    }

    /**
     * GIVEN an anonymous-user cookie sent in plain text
     * WHEN a visitor registers
     * THEN the cookie is ignored
     */
    #[Test]
    public function register_ignores_unencrypted_anonymous_cookie(): void {
        $anonymousUser = $this->createAnonymousUser();

        $this->withUnencryptedCookie(UserManager::$USER_COOKIE_KEY, (string) $anonymousUser->id)
            ->post(route('register', ['locale' => 'en']), $this->registrationData('plain-cookie@example.com'));

        $this->assertNotSame($anonymousUser->id, User::where('email', 'plain-cookie@example.com')->firstOrFail()->id);
        $this->assertNull($anonymousUser->refresh()->password);
    }

    /**
     * GIVEN a valid anonymous-user cookie
     * WHEN the anonymous visitor registers
     * THEN the anonymous account becomes the registered account
     */
    #[Test]
    public function register_converts_the_anonymous_account_of_the_visitor(): void {
        $anonymousUser = $this->createAnonymousUser();

        $this->withCookie(UserManager::$USER_COOKIE_KEY, (string) $anonymousUser->id)
            ->post(route('register', ['locale' => 'en']), $this->registrationData('converted@example.com'));

        $anonymousUser->refresh();
        $this->assertSame('converted@example.com', $anonymousUser->email);
        $this->assertNotNull($anonymousUser->password);
    }

    private function createAnonymousUser(): User {
        $name = 'Anonymous_User_' . uniqid();

        return User::create(['nickname' => $name, 'email' => $name . '@crowd.org']);
    }

    private function registrationData(string $email): array {
        return [
            'nickname' => 'nick' . uniqid(),
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 'male',
            'country' => 'US',
            'year-of-birth' => 1990,
        ];
    }
}
