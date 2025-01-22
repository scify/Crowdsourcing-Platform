<?php

namespace Feature\Controllers\Auth;

use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterControllerTest extends TestCase {
    protected function setUp(): void {
        parent::setUp();
        Notification::fake();
    }

    /**
     * @test
     *
     * @group register-controller
     *
     * GIVEN valid user data
     * WHEN create method is called
     * THEN a new user should be created and assigned the registered user role
     */
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
     * @test
     *
     * @group register-controller
     *
     * GIVEN user data with an existing email
     * WHEN create method is called
     * THEN the user should not be created and an error should be returned
     */
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
     * @test
     *
     * @group register-controller
     *
     * GIVEN user data with invalid year of birth
     * WHEN create method is called
     * THEN the user should not be created and an error should be returned
     */
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
     * @test
     *
     * @group register-controller
     *
     * GIVEN user data with missing required fields
     * WHEN create method is called
     * THEN the user should not be created and errors should be returned
     */
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
}
