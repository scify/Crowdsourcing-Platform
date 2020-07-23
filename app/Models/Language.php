<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/5/18
 * Time: 3:49 PM
 */

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
        'default_color'
    ];
}
