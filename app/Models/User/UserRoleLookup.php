<?php

declare(strict_types=1);

namespace App\Models\User;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserRoleLookup
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRoleLookup withoutTrashed()
 *
 * @mixin Eloquent
 */
class UserRoleLookup extends Model {
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
        'name',
    ];
}
