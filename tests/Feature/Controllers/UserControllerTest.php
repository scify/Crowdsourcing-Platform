<?php

namespace Tests\Feature\Controllers;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase {

    use RefreshDatabase;

    protected $seed = true;

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

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('updateUser'), [
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
    public function patchRedirectsToLoginForUnauthenticatedUser() {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('updateUser'), [
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

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('updateUser'), [
                'nickname' => 'updated-nickname',
                'password' => '1234',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function cannotDeleteDeactivatesUserForNonAdminUser() {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('deleteUser'), ['id' => $user->id]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
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

        $response = $this->get(route('filterUsers', ['name' => 'John']));

        $response->assertStatus(200);
    }

    /** @test */
    public function showUsersByCriteriaRedirectsToLoginForUnauthenticatedUser() {
        $response = $this->get(route('filterUsers', ['name' => 'John']));

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /** @test */
    public function nonAdminUserCannotGetUsersByCriteria() {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->get(route('filterUsers'));

        $response->assertStatus(403);
    }
}
