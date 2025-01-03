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
    private $userRoleRepository;

    public function __construct(UserRoleRepository $userRoleRepository) {
        $this->userRoleRepository = $userRoleRepository;
    }

    public function registerUserPolicies() {
        Gate::define('manage-platform', function ($user) {
            return $this->userHasAdminRole($user);
        });

        Gate::define('manage-users', function ($user) {
            return $this->userHasAdminRole($user);
        });

        Gate::define('manage-platform-content', function ($user) {
            return $this->userHasAdminRole($user) || $this->userHasContentManagerRole($user);
        });

        Gate::define('create-platform-content', function ($user) {
            return $this->userHasAdminRole($user)
                || $this->userHasContentManagerRole($user)
                || $this->userHasModeratorRole($user);
        });

        Gate::define('moderate-content-by-users', function ($user) {
            return $this->userHasAdminRole($user)
                || $this->userHasContentManagerRole($user)
                || $this->userHasModeratorRole($user);
        });
    }

    public function assignRegisteredUserRoleTo($user) {
        return $this->userRoleRepository->assignRoleToUser($user->id, UserRoles::REGISTERED_USER);
    }

    /**
     * Checks if a given @see User has the admin role
     *
     * @param  User  $user the @see User instance
     * @return bool
     */
    public function userHasAdminRole(User $user) {
        return $this->userHasRole($user, UserRolesLkp::ADMIN, 'user_is_admin');
    }

    /**
     * Checks if a given @see User has the Answers Moderator role
     *
     * @param  User  $user the @see User instance
     * @return bool
     */
    public function userHasModeratorRole(User $user) {
        return $this->userHasRole($user, UserRolesLkp::ANSWERS_MODERATOR, 'user_is_moderator');
    }

    /**
     * Checks if a given @see User has the content manager role
     *
     * @param  User  $user the @see User instance
     * @return bool
     */
    public function userHasContentManagerRole(User $user) {
        return $this->userHasRole($user, UserRolesLkp::CONTENT_MANAGER, 'user_is_content_manager');
    }

    /**
     * Checks if a given @param  User  $user the @see User instance
     *
     * @return bool
     *
     * @see User has the admin role
     */
    public function userHasRole(User $user, int $roleId, string $roleKeyForCache) {
        if ($user == null) {
            return false;
        }

        return $this->checkCacheOrDBForRoleAndStore($roleKeyForCache, $user, $roleId);
    }

    /**
     * Checks if a role (identified by role id) exists in a given collection of @see UserRole
     *
     * @param  Collection  $userRoles the user roles collection
     * @param  int  $roleId
     * @return bool
     */
    private function rolesInclude(Collection $userRoles, $roleId) {
        return $userRoles->contains($roleId);
    }

    private function checkCacheOrDBForRoleAndStore($roleKey, User $user, $roleId) {
        $result = Cache::get($roleKey . $user->id);
        if ($result == null) {
            $userRoles = $user->roles;
            $result = $this->rolesInclude($userRoles, $roleId);
            Cache::put($roleKey . $user->id, $result, 5000);
        }

        return $result;
    }
}
