<?php

namespace App\Models\CrowdSourcingProject\Problem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrowdSourcingProjectProblem extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'crowd_sourcing_project_problems';
    protected $fillable = ['id', 'project_id', 'slug', 'status_id', 'img_url', 'default_language_id'];
}
