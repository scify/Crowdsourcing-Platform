<?php

namespace App\BusinessLogicLayer;

use App\Models\User;
use Gate;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class PermissionsManager
{

    //ATTENTION: these values match with the db values defined in database\seeds\UsersRoles.php
    const ADMIN = 1; //the platform administrator
    const PUBLISHER = 2; //the cms owner. Has registered and created a new CMS
    const CHIEF = 3; //created by a publisher. He can administer / release new articles
    const JOURNALIST = 4;

    public function registerUserPolicies()
    {
        Gate::define('view-my-profile', function ($user) {
            return $this->userHasPermission($user, 'view-my-profile');
        });

        Gate::define('create-or-edit-article', function ($user) {
            return $this->userHasPermission($user,  'create-or-edit-article');
        });

        Gate::define('view-my-articles', function ($user) {
            return $this->userHasPermission($user,  'view-my-articles');
        });

        Gate::define('view-collaboration-requests', function ($user) {
            return $this->userHasPermission($user,  'view-collaboration-requests');
        });

        Gate::define("view-blog-roll", function ($user) {
            return $this->userHasPermission($user,  "view-blog-roll");
        });

        Gate::define("view-edit-room", function ($user) {

            return $this->userHasPermission($user,  "view-edit-room");
        });


        Gate::define('view-chief-room', function ($user) {
            return $this->userHasPermission($user,  'view-chief-room');
        });

        Gate::define('manage-cms', function ($user) {
            return $this->userHasPermission($user,  'manage-cms');
        });

        Gate::define('manage-platform', function ($user) {
            return $this->userHasPermission($user,  'manage-platform');
        });

        Gate::define('buy-article', function ($user) {
            return $this->userHasPermission($user,  'buy-article');
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
                return in_array($roleId, [self::PUBLISHER, self::CHIEF, self::JOURNALIST]);
            case "create-or-edit-article":
                return in_array($roleId, [self::PUBLISHER, self::CHIEF, self::JOURNALIST]);
            case "view-my-articles":
                return in_array($roleId, [self::PUBLISHER, self::CHIEF, self::JOURNALIST]);
            case "view-collaboration-requests":
                return in_array($roleId, [self::JOURNALIST]);
            case "view-blog-roll":
                return in_array($roleId, [self::PUBLISHER, self::CHIEF]);
            case "view-edit-room":
                return in_array($roleId, [self::PUBLISHER, self::CHIEF]);
            case "view-chief-room":
                return in_array($roleId, [self::PUBLISHER, self::CHIEF]);
            case "make-article-sticky":
                return in_array($roleId, [self::PUBLISHER, self::CHIEF]);
            case "buy-article":
                return in_array($roleId, [self::PUBLISHER, self::CHIEF]);
            case "manage-cms":
                return in_array($roleId, [self::ADMIN, self::PUBLISHER]);
            case "manage-platform":
                return in_array($roleId, [self::ADMIN]);
            default:
                throw new AccessDeniedException("Could not verify ability " . $ability . " for role " . $roleId);
        }

    }
}
