<?php

namespace Tests\Feature\Controllers;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User\User;
use App\Models\User\UserRole;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase {
    protected function setUp(): void {
        parent::setUp();

        // Use the system's temporary directory
        $tempDir = sys_get_temp_dir();

        // Ensure the temporary directory is writable
        if (!is_writable($tempDir)) {
            throw new \RuntimeException("The temporary directory is not writable: {$tempDir}");
        }
    }

    #[Test]
    public function my_dashboard_displays_dashboard_for_authenticated_user(): void {
        // print database connection in use
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->get(route('my-dashboard', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.my-dashboard');
    }

    #[Test]
    public function my_dashboard_redirects_to_login_for_unauthenticated_user(): void {
        $response = $this->get(route('my-dashboard', ['locale' => 'en']));

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function my_account_displays_account_page_for_authenticated_user(): void {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->get(route('my-account', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.my-account');
    }

    #[Test]
    public function my_account_redirects_to_login_for_unauthenticated_user(): void {
        $response = $this->get(route('my-account', ['locale' => 'en']));

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function patch_updates_user_profile_with_valid_data(): void {
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
                'gender' => 'female',
                'country' => 'Greece',
                'year-of-birth' => 1990,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'Profile updated.');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nickname' => 'updated-nickname',
        ]);
    }

    #[Test]
    public function patch_updates_user_profile_with_valid_data_with_image(): void {
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
                'gender' => 'female',
                'country' => 'Greece',
                'year-of-birth' => 1990,
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

    #[Test]
    public function patch_updates_user_profile_with_invalid_image(): void {
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

    #[Test]
    public function path_updates_user_profile_with_very_big_image(): void {
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

    #[Test]
    public function patch_redirects_to_login_for_unauthenticated_user(): void {
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
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function patch_handles_invalid_data_correctly(): void {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('user.update'), [
                'nickname' => 'updated-nickname',
                'password' => '1234',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password', 'email']);
    }

    #[Test]
    public function delete_deactivates_user_for_admin_user(): void {
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

    #[Test]
    public function delete_redirects_to_login_for_unauthenticated_user(): void {
        $user = User::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('deleteUser'), ['id' => $user->id]);

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function delete_handles_invalid_user_id_correctly(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('deleteUser'), ['id' => 999]);

        $response->assertStatus(404);
    }

    #[Test]
    public function show_users_by_criteria_returns_correct_users(): void {
        User::factory()->create(['nickname' => 'John Doe']);
        User::factory()->create(['nickname' => 'Jane Doe']);
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('api.users.get-filtered', ['name' => 'John']));

        $response->assertStatus(200);
    }

    #[Test]
    public function show_users_by_criteria_redirects_to_login_for_unauthenticated_user(): void {
        $response = $this->get(route('api.users.get-filtered', ['name' => 'John']));

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function non_admin_user_cannot_get_users_by_criteria(): void {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->get(route('api.users.get-filtered'));

        $response->assertStatus(403);
    }

    #[Test]
    public function my_dashboard_displays_correctly_for_user_with_no_badges(): void {
        // for this test, we want to emulate that the platform does not have any questionnaires or projects
        // delete all questionnaires and projects
        Questionnaire::query()->delete();
        CrowdSourcingProject::query()->delete();

        $user = User::factory()->create();
        $this->be($user);

        $response = $this->get(route('my-dashboard', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.my-dashboard');
        $response->assertViewHas('viewModel');
        $viewModel = $response->original->getData()['viewModel'];
        $this->assertCount(3, $viewModel->platformWideGamificationBadgesVM->badgesWithLevelsList);
        $this->assertCount(0, $viewModel->questionnaires);
        $this->assertCount(0, $viewModel->projectsWithActiveProblems);
    }
}
