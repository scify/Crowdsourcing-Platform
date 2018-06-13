<?php

namespace App\BusinessLogicLayer;

use App\Models\User;
use Gate;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class PermissionsManager
{

    //ATTENTION: these values match with the db values defined in database\seeds\UsersRoles.php
    const ADMIN = 1;
    const CONTENT_MANAGER = 2;
    const REGISTERED_USER = 3;

    public function registerUserPolicies()
    {
        Gate::define('view-my-profile', function ($user) {
            return $this->userHasPermission($user, 'view-my-profile');
        });

        Gate::define('manage-platform', function ($user) {
            return $this->userHasPermission($user,  'manage-platform');
        });


        Gate::define('delete-article', function ($user, $id) {
//            $article = $this->articleRepository->find($id);
//            // if user is journalist, check whether they are the creator of the article
//            if ($this->userHasRole($user, self::JOURNALIST)) {
//                return $article->last_edited_by_user_id == $user->id;
//            }
//            // if user is publisher or chief, then the article has to have the same CMS as the selected user roles's CMS
//            return $this->userHasRoleForCMS($user, self::PUBLISHER, $article->cms_id) || $this->userHasRoleForCMS($user, self::CHIEF, $article->cms_id);
        });
    }

    private function userHasRole(User $user, int $role)
    {
        $roleIds = $user->roles()->get()->pluck("id")->toArray();
        return in_array($role, $roleIds);
    }


    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function userHasPermission($user, $ability)
    {

        $roleIds = $user->roles()->get()->pluck("id")->toArray();

        foreach ($roleIds as $roleId) {
            if ($this->roleHasAccessToAbility($roleId, $ability))
                return true;
        }
        return false;
    }

    private function roleHasAccessToAbility($roleId, $ability)
    {
        switch ($ability) {
            case "view-my-profile":
                return in_array($roleId, [self::ADMIN, self::CONTENT_MANAGER, self::REGISTERED_USER]);
            case "manage-platform":
                return in_array($roleId, [self::ADMIN]);
            default:
                throw new AccessDeniedException("Could not verify ability " . $ability . " for role " . $roleId);
        }

    }
}
