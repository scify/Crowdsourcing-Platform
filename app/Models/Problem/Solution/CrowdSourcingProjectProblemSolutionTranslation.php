<?php

namespace App\Models\Problem\Solution;

use App\Models\CompositeKeysModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrowdSourcingProjectProblemSolutionTranslation extends CompositeKeysModel {
    use HasFactory;

    protected $table = 'crowd_sourcing_project_problem_solution_translations';
    protected $fillable = ['solution_id', 'language_id', 'title', 'description'];
    protected $primaryKey = ['solution_id', 'language_id'];
    public $incrementing = false;
}
