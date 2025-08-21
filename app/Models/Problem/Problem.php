<?php

declare(strict_types=1);

namespace App\Models\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Solution\Solution;
use App\Models\User\User;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Problem extends Model {
    use Compoships;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'problems';

    protected $fillable = ['id', 'project_id', 'user_creator_id', 'slug', 'status_id', 'img_url', 'default_language_id'];

    protected $with = ['defaultTranslation'];

    public function defaultTranslation(): HasOne {
        return $this->hasOne(ProblemTranslation::class,
            ['problem_id', 'language_id'], ['id', 'default_language_id']);
    }

    public function translations(): HasMany {
        return $this->hasMany(ProblemTranslation::class, 'problem_id', 'id');
    }

    public function status(): HasOne {
        return $this->hasOne(ProblemStatusLkp::class, 'id', 'status_id');
    }

    public function bookmarks(): HasMany {
        return $this->hasMany(ProblemUserBookmark::class, 'problem_id', 'id');
    }

    public function solutions(): HasMany {
        return $this->hasMany(Solution::class, 'problem_id', 'id');
    }

    public function project(): HasOne {
        return $this->hasOne(CrowdSourcingProject::class, 'id', 'project_id');
    }

    public function creator(): HasOne {
        return $this->hasOne(User::class, 'id', 'user_creator_id');
    }

    // observe this model being deleted and delete the related records
    protected static function boot(): void {
        parent::boot();

        self::deleting(function (Problem $problem): void {
            foreach ($problem->translations as $translation) {
                $translation->delete();
            }

            foreach ($problem->bookmarks as $bookmark) {
                $bookmark->delete();
            }
        });
    }
}
