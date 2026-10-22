<?php

declare(strict_types=1);

namespace App\Models\Problem;

use App\Models\Language;
use App\Models\User\User;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $problem_id
 * @property int $user_id
 * @property int $problem_bookmark_language_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Language|null $language
 * @property-read Problem|null $problem
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemUserBookmark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemUserBookmark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemUserBookmark query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemUserBookmark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemUserBookmark whereProblemBookmarkLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemUserBookmark whereProblemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemUserBookmark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemUserBookmark whereUserId($value)
 *
 * @mixin \Eloquent
 */
class ProblemUserBookmark extends Model {
    use Compoships;

    protected $table = 'problem_user_bookmarks';

    protected $fillable = ['problem_id', 'user_id', 'problem_bookmark_language_id'];

    protected $primaryKey = ['problem_id', 'user_id'];

    public $incrementing = false;

    public function problem(): BelongsTo {
        return $this->belongsTo(Problem::class, 'problem_id', 'id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'problem_bookmark_language_id', 'id');
    }
}
