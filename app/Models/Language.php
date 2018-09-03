<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/5/18
 * Time: 3:49 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $language_code
 * @property string $language_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereLanguageName($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    protected $table = 'languages_lkp';
}