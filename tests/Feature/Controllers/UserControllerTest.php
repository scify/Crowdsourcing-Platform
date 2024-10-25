<?php

namespace Tests\Feature\Controllers;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User;
use App\Models\UserRole;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserControllerTest extends TestCase {
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void {
        parent::setUp();

        // Use the system's temporary directory
        $tempDir = sys_get_temp_dir();

        // Ensure the temporary directory is writable
        if (!is_writable($tempDir)) {
            throw new \RuntimeException("The temporary directory is not writable: {$tempDir}");
        }
    }

    /** @test */
    public function myDashboardDisplaysDashboardForAuthenticated_user() {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->get(route('my-dashboard', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('loggedin-environment.my-dashboard');
    }

    /** @test */
    public function myDashboardRedirectsToLoginForUnauthenticated_user() {
        $response = $this->get(route('my-dashboard', ['locale' => 'en']));

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /** @test */
    public function myAccountDisplaysAccountPageForAuthenticatedUser() {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->get(route('my-account', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('loggedin-environment.my-account');
    }

    /** @test */
    public function myAccountRedirectsToLoginForUnauthenticatedUser() {
        $response = $this->get(route('my-account', ['locale' => 'en']));

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /** @test */
    public function patchUpdatesUserProfileWithValidData() {
        $user = User::factory()->create();
        $this->be($user);
        $faker = Faker::create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('user.update'), [
                'email' => $faker->email,
                'nickname' => 'updated-nickname',
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'current_password' => 'password',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'Profile updated.');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nickname' => 'updated-nickname',
        ]);
    }

    /** @test */
    public function patchUpdatesUserProfileWithValidDataWithImage() {
        $user = User::factory()->create();
        $this->be($user);
        $faker = Faker::create();
        // Use the system's temporary directory
        $tempDir = sys_get_temp_dir();
        $fakeImage = $faker->image($tempDir, 400, 300, 'cats', false, false, 'Faker');

        // Check if the image was created successfully
        if (!$fakeImage) {
            echo "Warning: Failed to create a fake image. Using a default image.\n";
            $defaultImagePath = public_path('images/image_temp.png');
            $fakeImage = public_path('images/default_image_copy.png');
            if (!copy($defaultImagePath, $fakeImage)) {
                throw new \RuntimeException('Failed to copy the default image.');
            }
        } else {
            $fakeImage = $tempDir . '/' . $fakeImage;
        }

        echo 'IMAGE: ' . $fakeImage . PHP_EOL;
        // Create a fake image uploaded file, using the fake image
        $fakeImageUploadedFile = new UploadedFile($fakeImage, 'fake-image.jpg', 'image/jpeg', null, true);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('user.update'), [
                'email' => $faker->email,
                'nickname' => 'updated-nickname',
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'current_password' => 'password',
                'avatar' => $fakeImageUploadedFile,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'Profile updated.');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nickname' => 'updated-nickname',
        ]);

        // Assert the avatar is not null
        $this->assertNotNull(User::find($user->id)->avatar);
        // Get file name with extension from the avatar (the avatar has the full path, like /storage/uploads/user_profile_img/flowerpng_1729755672.png)
        $avatar = basename(User::find($user->id)->avatar);
        \File::delete(storage_path('app') . '/public/uploads/user_profile_img/' . $avatar);
        // delete the large image
        \File::delete($fakeImage);
    }

    /** @test */
    public function patchUpdatesUserProfileWithInvalidImage() {
        $user = User::factory()->create();
        $this->be($user);
        $faker = Faker::create();

        $defaultTextFilePath = public_path('images/test/test.txt');
        $fakeTxtFile = public_path('images/test_copy.txt');
        if (!copy($defaultTextFilePath, $fakeTxtFile)) {
            throw new \RuntimeException('Failed to copy the default image.');
        }

        $fakeImageUploadedFile = new UploadedFile($fakeTxtFile, 'fake-image.jpg', 'image/jpeg', null, true);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('user.update'), [
                'email' => $faker->email,
                'nickname' => 'updated-nickname',
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'current_password' => 'password',
                'avatar' => $fakeImageUploadedFile,
            ]);

        // assert that the response is a redirect
        $response->assertStatus(302);
        // assert that the session has errors
        $response->assertSessionHasErrors(['avatar']);

        // delete the fake txt file
        \File::delete($fakeTxtFile);
    }

    /** @test */
    public function pathUpdatesUserProfileWithVeryBigImage() {
        $user = User::factory()->create();
        $this->be($user);
        $faker = Faker::create();
        // Use the system's temporary directory
        $tempDir = sys_get_temp_dir();
        $largeImage = $faker->image($tempDir, 3000, 3000, 'cats', false, false, 'Faker');

        // Check if the image was created successfully
        if (!$largeImage) {
            echo "Warning: Failed to create a fake image. Using a default large image.\n";
            $defaultImagePath = public_path('images/test/image_temp_big.jpg');
            $largeImage = public_path('images/test/image_temp_big_copy.jpg');
            if (!copy($defaultImagePath, $largeImage)) {
                throw new \RuntimeException('Failed to copy the default large image.');
            }
        } else {
            $largeImage = $tempDir . '/' . $largeImage;
        }

        $largeImageUploadedFile = new UploadedFile($largeImage, 'fake-image.jpg', 'image/jpeg', null, true);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('user.update'), [
                'email' => $faker->email,
                'nickname' => 'updated-nickname',
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'current_password' => 'password',
                'avatar' => $largeImageUploadedFile,
            ]);

        // Assert that the response is a redirect
        $response->assertStatus(302);
        // Assert that the session has errors related to the avatar
        $response->assertSessionHasErrors(['avatar']);
        // delete the large image
        \File::delete($largeImage);
    }

    /** @test */
    public function patchRedirectsToLoginForUnauthenticatedUser() {
        $faker = Faker::create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('user.update'), [
                'email' => $faker->email,
                'nickname' => 'updated-nickname',
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'current_password' => 'password',
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /** @test */
    public function patchHandlesInvalidDataCorrectly() {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this
            ->put(route('user.update'), [
                'nickname' => 'updated-nickname',
                'password' => '1234',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password', 'email']);
    }

    /** @test */
    public function deleteDeactivatesUserForAdminUser() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('deleteUser'), ['id' => $user->id]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'User deleted.');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => \DB::raw('deleted_at IS NOT NULL'),
        ]);
    }

    /** @test */
    public function deleteRedirectsToLoginForUnauthenticatedUser() {
        $user = User::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('deleteUser'), ['id' => $user->id]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /** @test */
    public function deleteHandlesInvalidUserIdCorrectly() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('deleteUser'), ['id' => 999]);

        $response->assertStatus(404);
    }

    /** @test */
    public function showUsersByCriteriaReturnsCorrectUsers() {
        $user1 = User::factory()->create(['nickname' => 'John Doe']);
        $user2 = User::factory()->create(['nickname' => 'Jane Doe']);
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('api.users.get-filtered', ['name' => 'John']));

        $response->assertStatus(200);
    }

    /** @test */
    public function showUsersByCriteriaRedirectsToLoginForUnauthenticatedUser() {
        $response = $this->get(route('api.users.get-filtered', ['name' => 'John']));

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /** @test */
    public function nonAdminUserCannotGetUsersByCriteria() {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->get(route('api.users.get-filtered'));

        $response->assertStatus(403);
    }

    /** @test */
    public function myDashboardDisplaysCorrectlyForUserWithNoBadges() {
        // for this test, we want to emulate that the platform does not have any questionnaires or projects
        // delete all questionnaires and projects
        Questionnaire::query()->delete();
        CrowdSourcingProject::query()->delete();

        $user = User::factory()->create();
        $this->be($user);

        $response = $this->get(route('my-dashboard', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('loggedin-environment.my-dashboard');
        $response->assertViewHas('viewModel');
        $viewModel = $response->original->getData()['viewModel'];
        $this->assertCount(3, $viewModel->platformWideGamificationBadgesVM->badgesWithLevelsList);
        $this->assertCount(0, $viewModel->questionnaires);
        $this->assertCount(0, $viewModel->projectsWithActiveProblems);
    }
}
