<?php

declare(strict_types=1);

namespace App\Models\Problem;

use App\Models\CompositeKeysModel;
use App\Models\Language;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $problem_id
 * @property int $language_id
 * @property string $title
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Language|null $language
 * @property-read Problem|null $problem
 *
 * @method static \Database\Factories\Problem\ProblemTranslationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation whereProblemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemTranslation whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ProblemTranslation extends CompositeKeysModel {
    use Compoships;
    use HasFactory;

    protected $table = 'problem_translations';

    protected $fillable = ['problem_id', 'language_id', 'title', 'description'];

    protected $primaryKey = ['problem_id', 'language_id'];

    public $incrementing = false;

    public function problem(): BelongsTo {
        return $this->belongsTo(Problem::class, 'problem_id', 'id');
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
