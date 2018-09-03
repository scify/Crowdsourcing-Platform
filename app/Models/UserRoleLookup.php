<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserRoleLookup
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserRoleLookup onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoleLookup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoleLookup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoleLookup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoleLookup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoleLookup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserRoleLookup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserRoleLookup withoutTrashed()
 * @mixin \Eloquent
 */
class UserRoleLookup extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_role_lkp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
