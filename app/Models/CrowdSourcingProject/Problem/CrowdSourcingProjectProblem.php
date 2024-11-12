<?php

namespace App\Models\CrowdSourcingProject\Problem;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrowdSourcingProjectProblem extends Model {
    use Compoships;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'crowd_sourcing_project_problems';
    protected $fillable = ['id', 'project_id', 'user_creator_id', 'slug', 'status_id', 'img_url', 'default_language_id'];

    public function defaultTranslation(): HasOne {
        return $this->hasOne(CrowdSourcingProjectProblemTranslation::class,
            ['problem_id', 'language_id'], ['id', 'default_language_id']);
    }

    public function translations(): HasMany {
        return $this->hasMany(CrowdSourcingProjectProblemTranslation::class, 'problem_id', 'id');
    }

    public function status(): HasOne {
        return $this->hasOne(CrowdSourcingProjectProblemStatusLkp::class, 'id', 'status_id');
    }
}
