<?php

namespace App\Models\CrowdSourcingProject\Problem\Solution;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CompositeKeysModel;

class CrowdSourcingProjectProblemSolutionUpvote extends CompositeKeysModel
{
    use HasFactory;

    protected $table = 'crowd_sourcing_project_problem_solution_upvotes';

    protected $fillable = ['solution_id', 'user_voter_id'];


    protected $primaryKey = ['solution_id', 'user_voter_id'];

    public $incrementing = false;
}
