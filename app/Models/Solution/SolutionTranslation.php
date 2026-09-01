<?php

declare(strict_types=1);

namespace App\Models\Solution;

use App\Models\CompositeKeysModel;
use App\Models\Language;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $solution_id
 * @property int $language_id
 * @property string $title
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Language|null $language
 * @property-read Solution|null $solution
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation whereSolutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionTranslation whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class SolutionTranslation extends CompositeKeysModel {
    use Compoships;
    use HasFactory;

    protected $table = 'solution_translations';

    protected $fillable = ['solution_id', 'language_id', 'title', 'description'];

    protected $primaryKey = ['solution_id', 'language_id'];

    public $incrementing = false;

    public function solution(): BelongsTo {
        return $this->belongsTo(Solution::class, 'solution_id', 'id');
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
