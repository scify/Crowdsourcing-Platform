<?php

namespace App\Models\Problem;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Problem extends Model {
    use Compoships;
    use HasFactory;

    protected $table = 'problems';
    protected $fillable = ['id', 'project_id', 'user_creator_id', 'slug', 'status_id', 'img_url', 'default_language_id'];

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

    //observe this model being deleted and delete the related records
    public static function boot() {
        parent::boot();

        self::deleting(function (Problem $problem) {
            foreach ($problem->translations as $translation) {
                $translation->delete();
            }
            foreach ($problem->bookmarks as $bookmark) {
                $bookmark->delete();
            }
        });
    }
}
