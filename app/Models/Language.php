<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $language_code
 * @property string $language_name
 * @property string $default_color
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
