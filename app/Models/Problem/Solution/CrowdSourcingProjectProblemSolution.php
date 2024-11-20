<?php

namespace App\Models\Problem\Solution;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrowdSourcingProjectProblemSolution extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'crowd_sourcing_project_problem_solutions';
    protected $fillable = ['id', 'problem_id', 'user_creator_id', 'slug', 'status_id', 'img_url'];
}
