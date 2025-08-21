<?php

declare(strict_types=1);

namespace App\Models\Solution;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
