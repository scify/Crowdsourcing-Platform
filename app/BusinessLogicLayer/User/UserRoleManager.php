<?php

namespace App\BusinessLogicLayer\User;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\User\User;
use App\Models\User\UserRole;
use App\Repository\User\UserRoleRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class UserRoleManager {
    public function __construct(private readonly UserRoleRepository $userRoleRepository) {}

    public function registerUserPolicies(): void {
        Gate::define('manage-platform', fn ($user): bool => $this->userHasAdminRole($user));

        Gate::define('manage-users', fn ($user): bool => $this->userHasAdminRole($user));

        Gate::define('manage-platform-content', function ($user): bool {
            if ($this->userHasAdminRole($user)) {
                return true;
            }

            return $this->userHasContentManagerRole($user);
        });

        Gate::define('create-platform-content', function ($user): bool {
            if ($this->userHasAdminRole($user)) {
                return true;
            }
            if ($this->userHasContentManagerRole($user)) {
                return true;
            }

            return $this->userHasModeratorRole($user);
        });

        Gate::define('moderate-content-by-users', function ($user): bool {
            if ($this->userHasAdminRole($user)) {
                return true;
            }
            if ($this->userHasContentManagerRole($user)) {
                return true;
            }

            return $this->userHasModeratorRole($user);
        });
    }

    public function assignRegisteredUserRoleTo($user): UserRole {
        return $this->userRoleRepository->assignRoleToUser($user->id, UserRoles::REGISTERED_USER);
    }

    /**
     * Checks if a given @see User has the admin role
     *
     * @param  User  $user the @see User instance
     */
    public function userHasAdminRole(User $user): bool {
        return $this->userHasRole($user, UserRolesLkp::ADMIN, 'user_is_admin');
    }

    /**
     * Checks if a given @see User has the Answers Moderator role
     *
     * @param  User  $user the @see User instance
     */
    public function userHasModeratorRole(User $user): bool {
        return $this->userHasRole($user, UserRolesLkp::ANSWERS_MODERATOR, 'user_is_moderator');
    }

    /**
     * Checks if a given @see User has the content manager role
     *
     * @param  User  $user the @see User instance
     */
    public function userHasContentManagerRole(User $user): bool {
        return $this->userHasRole($user, UserRolesLkp::CONTENT_MANAGER, 'user_is_content_manager');
    }

    public function userHasRegisteredUserRole(User $user): bool {
        return $this->userHasRole($user, UserRolesLkp::REGISTERED_USER, 'user_is_registered');
    }

    /**
     * Checks if a given
     * @param User $user the @see User instance
     * @see User has the admin role
     */
    public function userHasRole(User $user, int $roleId, string $roleKeyForCache): bool {
        if ($user == null) {
            return false;
        }

        return $this->checkCacheOrDBForRoleAndStore($roleKeyForCache, $user, $roleId);
    }

    /**
     * Checks if a role (identified by role id) exists in a given collection of @see UserRole
     *
     * @param  Collection  $userRoles the user roles collection
     */
    private function rolesInclude(Collection $userRoles, int $roleId): bool {
        return $userRoles->contains($roleId);
    }

    private function checkCacheOrDBForRoleAndStore(string $roleKey, User $user, int $roleId) {
        $result = Cache::get($roleKey . $user->id);
        if ($result == null) {
            $userRoles = $user->roles;
            $result = $this->rolesInclude($userRoles, $roleId);
            Cache::put($roleKey . $user->id, $result, 5000);
        }

        return $result;
    }
}
