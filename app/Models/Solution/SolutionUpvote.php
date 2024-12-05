<?php

namespace App\Models\Solution;

use App\Models\CompositeKeysModel;
use App\Models\User\User;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolutionUpvote extends CompositeKeysModel {
    use Compoships, HasFactory;

    protected $table = 'solution_upvotes';
    protected $fillable = ['solution_id', 'user_voter_id'];
    protected $primaryKey = ['solution_id', 'user_voter_id'];
    public $incrementing = false;

    public function solution(): BelongsTo {
        return $this->belongsTo(Solution::class, 'solution_id', 'id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_voter_id', 'id');
    }
}
