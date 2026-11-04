<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessLogicLayer\User;

use App\BusinessLogicLayer\CookieManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Models\User\User;
use App\Repository\Questionnaire\Responses\QuestionnaireAnswerVoteRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\User\UserRepository;
use App\Repository\User\UserRoleRepository;
use App\Utils\MailChimpAdaptor;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserManagerTest extends TestCase {
    /**
     * GIVEN a valid cookie with user ID
     * AND the user does not exist in the database
     * WHEN createUser is called
     * THEN the cookie is deleted
     * AND a new user is created
     */
    #[Test]
    public function test_create_user_when_cookie_is_set_but_user_not_found(): void {
        // Mock dependencies
        $userRepositoryMock = Mockery::mock(UserRepository::class);
        $userRoleRepositoryMock = Mockery::mock(UserRoleRepository::class);
        $mailChimpAdaptorMock = Mockery::mock(MailChimpAdaptor::class);
        $questionnaireResponseRepositoryMock = Mockery::mock(QuestionnaireResponseRepository::class);
        $questionnaireAnswerVoteRepositoryMock = Mockery::mock(QuestionnaireAnswerVoteRepository::class);

        // Create a mock for CookieManager static methods
        $cookieManagerMock = Mockery::mock(CookieManager::class);
        $cookieUserId = 12345;

        // Set up expectations
        $cookieManagerMock->shouldReceive('getCookie')
            ->once()
            ->with(UserManager::$USER_COOKIE_KEY)
            ->andReturn($cookieUserId);

        $cookieManagerMock->shouldReceive('deleteCookie')
            ->once()
            ->with(UserManager::$USER_COOKIE_KEY);

        // The cookie points to a user that does not exist
        $userRepositoryMock->shouldReceive('getUser')
            ->once()
            ->with($cookieUserId)
            ->andReturn(null);

        // Mock UserRepository::create to create a new user
        $userRepositoryMock->shouldReceive('create')
            ->once()
            ->with(Mockery::type('array'))
            ->andReturn(new User(['nickname' => 'Test_User', 'email' => 'test_user@crowd.org']));

        // Initialize UserManager
        $userManager = new UserManager(
            $userRepositoryMock,
            $userRoleRepositoryMock,
            $mailChimpAdaptorMock,
            $questionnaireResponseRepositoryMock,
            $questionnaireAnswerVoteRepositoryMock,
            $cookieManagerMock
        );

        // Call the createUser method
        $result = $userManager->createUser([
            'email' => 'test_user@crowd.org',
            'nickname' => 'Test_User',
            'password' => 'password123',
            'gender' => 'Male',
            'country' => 'CountryX',
            'year-of-birth' => 1990,
        ]);

        // Assertions
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('Test_User', $result->nickname);
        $this->assertEquals('test_user@crowd.org', $result->email);
    }

    /**
     * GIVEN a valid cookie with user ID
     * AND the user is an anonymous user in the database
     * WHEN createUser is called
     * THEN the cookie is not deleted
     * AND the anonymous user is updated
     */
    #[Test]
    public function test_create_user_when_cookie_is_set_and_user_exists(): void {
        // Mock dependencies
        $userRepositoryMock = Mockery::mock(UserRepository::class);
        $userRoleRepositoryMock = Mockery::mock(UserRoleRepository::class);
        $mailChimpAdaptorMock = Mockery::mock(MailChimpAdaptor::class);
        $questionnaireResponseRepositoryMock = Mockery::mock(QuestionnaireResponseRepository::class);
        $questionnaireAnswerVoteRepositoryMock = Mockery::mock(QuestionnaireAnswerVoteRepository::class);
        $cookieManagerMock = Mockery::mock(CookieManager::class);

        $faker = Factory::create();
        $email = $faker->email;
        $nickname = $faker->userName;

        // An anonymous user that responded before registering
        $existingUser = User::create([
            'nickname' => 'Anonymous_User_' . uniqid(),
            'email' => 'Anonymous_User_' . uniqid() . '@crowd.org',
        ]);

        // Mock cookie value
        $cookieUserId = $existingUser->id;

        $cookieManagerMock->shouldReceive('getCookie')
            ->once()
            ->with(UserManager::$USER_COOKIE_KEY)
            ->andReturn($cookieUserId);

        $userRepositoryMock->shouldReceive('getUser')
            ->once()
            ->with($cookieUserId)
            ->andReturn($existingUser);

        $userRepositoryMock->shouldReceive('find')
            ->once()
            ->with($cookieUserId)
            ->andReturnUsing(fn () => $existingUser->fill(['email' => $email, 'nickname' => $nickname]));

        // Mock user update
        $userRepositoryMock->shouldReceive('update')
            ->once()
            ->with(Mockery::on(fn ($data): bool => $data['email'] === $email
                && $data['nickname'] === $nickname
                && isset($data['password'])
                && $data['gender'] === 'Female'
                && $data['country'] === 'CountryY'
                && $data['year_of_birth'] === 1992), $cookieUserId);

        // Do not expect the cookie to be deleted
        $cookieManagerMock->shouldNotReceive('deleteCookie');

        // Initialize UserManager
        $userManager = new UserManager(
            $userRepositoryMock,
            $userRoleRepositoryMock,
            $mailChimpAdaptorMock,
            $questionnaireResponseRepositoryMock,
            $questionnaireAnswerVoteRepositoryMock,
            $cookieManagerMock
        );

        // Call the createUser method
        $result = $userManager->createUser([
            'email' => $email,
            'nickname' => $nickname,
            'password' => 'password123',
            'gender' => 'Female',
            'country' => 'CountryY',
            'year-of-birth' => 1992,
        ]);

        // Assertions
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($nickname, $result->nickname);
        $this->assertEquals($email, $result->email);
    }

    /**
     * GIVEN no cookie and user is not logged in
     * WHEN getLoggedInUserOrCreateAnonymousUser is called
     * THEN an anonymous user should be created
     */
    #[Test]
    public function test_create_anonymous_user_when_no_cookie_and_not_logged_in(): void {
        // Mock dependencies
        $userRepositoryMock = Mockery::mock(UserRepository::class);
        $cookieManagerMock = Mockery::mock(CookieManager::class);
        // Mock Auth::check to return false
        Auth::shouldReceive('check')->andReturn(false);

        // Mock getCookie to return null
        $cookieManagerMock->shouldReceive('getCookie')
            ->once()
            ->with(UserManager::$USER_COOKIE_KEY)
            ->andReturn(null);

        // Mock UserRepository::create
        $userRepositoryMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(fn ($data): bool => isset($data['nickname']) && str_starts_with((string) $data['nickname'], 'Anonymous_User_')))
            ->andReturn(new User(['nickname' => 'Anonymous_User_12345', 'email' => 'Anonymous_User_12345@crowd.org']));

        // Initialize UserManager
        $userManager = new UserManager(
            $userRepositoryMock,
            Mockery::mock(UserRoleRepository::class),
            Mockery::mock(MailChimpAdaptor::class),
            Mockery::mock(QuestionnaireResponseRepository::class),
            Mockery::mock(QuestionnaireAnswerVoteRepository::class),
            $cookieManagerMock
        );

        // Call the method
        $result = $userManager->getLoggedInUserOrCreateAnonymousUser();

        // Assertions
        $this->assertInstanceOf(User::class, $result);
        $this->assertStringStartsWith('Anonymous_User_', $result->nickname);
        $this->assertStringEndsWith('@crowd.org', $result->email);
    }

    /**
     * GIVEN a cookie with the ID of a registered (non-anonymous) user
     * WHEN createUser is called
     * THEN the cookie is deleted
     * AND a new user is created instead of updating the registered user
     */
    #[Test]
    public function test_create_user_when_cookie_points_to_registered_user(): void {
        $userRepositoryMock = Mockery::mock(UserRepository::class);
        $cookieManagerMock = Mockery::mock(CookieManager::class);
        $registeredUser = User::factory()->create();

        $cookieManagerMock->shouldReceive('getCookie')
            ->once()
            ->with(UserManager::$USER_COOKIE_KEY)
            ->andReturn((string) $registeredUser->id);
        $cookieManagerMock->shouldReceive('deleteCookie')
            ->once()
            ->with(UserManager::$USER_COOKIE_KEY);
        $userRepositoryMock->shouldReceive('getUser')
            ->once()
            ->with($registeredUser->id)
            ->andReturn($registeredUser);
        $userRepositoryMock->shouldNotReceive('update');
        $userRepositoryMock->shouldReceive('create')
            ->once()
            ->andReturn(new User(['nickname' => 'New_User', 'email' => 'new_user@example.com']));

        $userManager = new UserManager(
            $userRepositoryMock,
            Mockery::mock(UserRoleRepository::class),
            Mockery::mock(MailChimpAdaptor::class),
            Mockery::mock(QuestionnaireResponseRepository::class),
            Mockery::mock(QuestionnaireAnswerVoteRepository::class),
            $cookieManagerMock
        );

        $result = $userManager->createUser([
            'email' => 'new_user@example.com',
            'nickname' => 'New_User',
            'password' => 'password123',
            'gender' => 'Male',
            'country' => 'CountryX',
            'year-of-birth' => 1990,
        ]);

        $this->assertSame('new_user@example.com', $result->email);
    }
}
