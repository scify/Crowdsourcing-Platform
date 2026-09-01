<?php

declare(strict_types=1);

namespace App\Models\Solution;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $solution_id
 * @property int $user_voter_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Solution|null $solution
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionUpvote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionUpvote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionUpvote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionUpvote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionUpvote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionUpvote whereSolutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionUpvote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionUpvote whereUserVoterId($value)
 *
 * @mixin \Eloquent
 */
class SolutionUpvote extends Model {
    use HasFactory;

    protected $table = 'solution_upvotes';

    protected $fillable = ['solution_id', 'user_voter_id'];

    public function solution(): BelongsTo {
        return $this->belongsTo(Solution::class, 'solution_id', 'id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_voter_id', 'id');
    }
}
