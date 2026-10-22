<?php

declare(strict_types=1);

namespace App\Models\Solution;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $solution_id
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Solution|null $solution
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionShare newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionShare newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionShare query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionShare whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionShare whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionShare whereSolutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionShare whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionShare whereUserId($value)
 *
 * @mixin \Eloquent
 */
class SolutionShare extends Model {
    protected $table = 'solution_shares';

    protected $fillable = [
        'solution_id',
        'user_id',
        'shared_at',
    ];

    public function solution(): BelongsTo {
        return $this->belongsTo(Solution::class, 'solution_id', 'id');
    }
}
