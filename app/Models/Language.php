<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $language_code
 * @property string $language_name
 * @property string $default_color
 * @property int $available_for_platform_translation
 * @property int $resources_translated
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereAvailableForPlatformTranslation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereDefaultColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereLanguageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereResourcesTranslated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Language withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Language extends Model {
    use SoftDeletes;

    protected $table = 'languages_lkp';

    protected $fillable = [
        'language_code',
        'language_name',
        'default_color',
    ];
}
