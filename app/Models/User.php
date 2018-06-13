<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function location()
    {
        return $this->hasOne(UserLocation::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(UserRoleLookup::class, 'user_roles', 'user_id', 'role_id')
            ->wherePivot('deleted_at', null);
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }

    public function collaborationRequests()
    {
        return $this->hasMany(CollaborationRequest::class, 'from_user_id', 'id');
    }

    public function collaborationResponses()
    {
        return $this->hasMany(CollaborationResponse::class, 'user_id', 'id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'last_edited_by_user_id', 'id');
    }

    public function articleActions()
    {
        return $this->hasMany(ArticleActionHistory::class, 'user_id', 'id');
    }

    public function articlePurchases()
    {
        return $this->hasMany(ArticlePurchase::class, 'purchased_by_user_id', 'id');
    }

    public function articlePurchasesOwned()
    {
        return $this->hasMany(ArticlePurchase::class, 'article_owner_user_id', 'id');
    }
}
