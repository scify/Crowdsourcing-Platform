<?php

declare(strict_types=1);

namespace App\Models\Solution;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Problem\Problem;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Znck\Eloquent\Traits\BelongsToThrough;

/**
 * @property int $id
 * @property int $problem_id
 * @property int|null $user_creator_id
 * @property string $slug
 * @property int $status_id
 * @property string|null $img_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $creator
 * @property-read SolutionTranslation|null $defaultTranslation
 * @property-read Problem|null $problem
 * @property-read Collection<int, SolutionShare> $shares
 * @property-read int|null $shares_count
 * @property-read SolutionStatusLkp $status
 * @property-read Collection<int, SolutionTranslation> $translations
 * @property-read int|null $translations_count
 * @property-read Collection<int, SolutionUpvote> $upvotes
 * @property-read int|null $upvotes_count
 * @property-read CrowdSourcingProject|null $project
 *
 * @method static \Database\Factories\Solution\SolutionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereProblemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution whereUserCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solution withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Solution extends Model {
    use BelongsToThrough;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'solutions';

    protected $fillable = ['id', 'problem_id', 'user_creator_id', 'slug', 'status_id', 'img_url'];

    protected $with = ['defaultTranslation'];

    // problem relationship (a solution belongs to a problem)
    public function problem(): BelongsTo {
        return $this->belongsTo(Problem::class, 'problem_id');
    }

    public function project(): \Znck\Eloquent\Relations\BelongsToThrough {
        return $this->belongsToThrough(CrowdSourcingProject::class,
            Problem::class,
            foreignKeyLookup: [CrowdSourcingProject::class => 'project_id'],
            localKeyLookup: [CrowdSourcingProject::class => 'id']);
    }

    // default translation relationship
    // the solution has the same default translation as the problem it belongs to.
    // but the records are stored in different tables (solution_translations and problem_translations)
    // so we need to take the default_language_id from the problem and use it to get the translation
    public function defaultTranslation(): HasOne {
        return $this->hasOne(SolutionTranslation::class, 'solution_id')
            ->join('solutions', 'solution_translations.solution_id', '=', 'solutions.id')
            ->join('problems', 'problems.id', '=', 'solutions.problem_id')
            ->whereColumn('solution_translations.language_id', 'problems.default_language_id')
            ->select('solution_translations.*');
    }

    public function translations(): HasMany {
        return $this->hasMany(SolutionTranslation::class, 'solution_id', 'id');
    }

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    public function status(): BelongsTo {
        return $this->belongsTo(SolutionStatusLkp::class, 'status_id');
    }

    public function upvotes(): HasMany {
        return $this->hasMany(SolutionUpvote::class, 'solution_id', 'id');
    }

    public function shares(): HasMany {
        return $this->hasMany(SolutionShare::class, 'solution_id', 'id');
    }
}
