<?php

namespace App\Models\Solution;

use App\Models\CompositeKeysModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolutionUpvote extends CompositeKeysModel {
    use HasFactory;

    protected $table = 'solution_upvotes';
    protected $fillable = ['solution_id', 'user_voter_id'];
    protected $primaryKey = ['solution_id', 'user_voter_id'];
    public $incrementing = false;
}
