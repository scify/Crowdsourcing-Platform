<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessLogicLayer\User;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\User\User;
use App\Models\User\UserRole;
use App\Repository\User\UserRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserRoleManagerTest extends TestCase {
    /**
     * GIVEN an admin whose admin role check is cached
     * WHEN the admin is demoted to a registered user
     * THEN the next role check returns false
     */
    #[Test]
    public function demoted_admin_loses_admin_role_immediately(): void {
        $user = User::factory()->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))->create();
        $userRoleManager = app(UserRoleManager::class);
        $this->assertTrue($userRoleManager->userHasAdminRole($user));

        app(UserRepository::class)->updateUserRoles($user->id, [null]);

        $this->assertFalse($userRoleManager->userHasAdminRole($user->fresh()));
        $this->assertTrue($userRoleManager->userHasRegisteredUserRole($user->fresh()));
    }

    /**
     * GIVEN a user whose missing admin role is cached
     * WHEN the user is promoted to admin
     * THEN the next role check returns true
     */
    #[Test]
    public function promoted_user_gets_admin_role_immediately(): void {
        $user = User::factory()->create();
        $userRoleManager = app(UserRoleManager::class);
        $this->assertFalse($userRoleManager->userHasAdminRole($user));

        app(UserRepository::class)->updateUserRoles($user->id, [UserRolesLkp::ADMIN]);

        $this->assertTrue($userRoleManager->userHasAdminRole($user->fresh()));
    }
}
