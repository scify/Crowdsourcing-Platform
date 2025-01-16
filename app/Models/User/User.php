<?php

namespace App\Models\User;

use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $nickname
 * @property string|null $avatar
 * @property string $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read Collection|UserRoleLookup[] $roles
 * @property-read Collection|UserRole[] $userRoles
 * @mixin Eloquent
 */
class User extends Authenticatable {
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'avatar', 'email', 'password', 'gender', 'country', 'year_of_birth',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany(UserRoleLookup::class, 'user_roles', 'user_id', 'role_id')
            ->wherePivot('deleted_at', null);
    }

    public function userRoles(): HasMany {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }

    public function sendPasswordResetNotification($token): void {
        // Your your own implementation.
        $this->notify(new ResetPassword($token));
    }
}
