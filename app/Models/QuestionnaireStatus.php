<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/11/18
 * Time: 12:22 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionnaireStatus
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatus whereTitle($value)
 * @mixin \Eloquent
 */
class QuestionnaireStatus extends Model
{
    protected $table = 'questionnaire_statuses_lkp';
}