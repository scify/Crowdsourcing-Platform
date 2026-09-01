<?php

declare(strict_types=1);

namespace App\Models\Problem;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Solution\Solution;
use App\Models\User\User;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $project_id
 * @property int|null $user_creator_id
 * @property string $slug
 * @property int $status_id
 * @property string|null $img_url
 * @property int $default_language_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, ProblemUserBookmark> $bookmarks
 * @property-read int|null $bookmarks_count
 * @property-read User|null $creator
 * @property ProblemTranslation|null $currentTranslation
 * @property-read ProblemTranslation|null $defaultTranslation
 * @property-read CrowdSourcingProject|null $project
 * @property-read Collection<int, Solution> $solutions
 * @property-read int|null $solutions_count
 * @property-read ProblemStatusLkp|null $status
 * @property-read Collection<int, ProblemTranslation> $translations
 * @property-read int|null $translations_count
 *
 * @method static \Database\Factories\Problem\ProblemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereDefaultLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem whereUserCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Problem withoutTrashed()
 *
 * @mixin \Eloquent
 */
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
