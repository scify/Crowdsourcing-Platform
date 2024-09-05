<?php

namespace App\Models\CrowdSourcingProject\Problem;

use App\Models\CompositeKeysModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrowdSourcingProjectProblemTranslation extends CompositeKeysModel
{
    use HasFactory;

    protected $table = 'crowd_sourcing_project_problem_translations';

    protected $fillable = ['problem_id', 'language_id', 'title', 'description'];


    protected $primaryKey = ['problem_id', 'language_id'];

    public $incrementing = false;
}
