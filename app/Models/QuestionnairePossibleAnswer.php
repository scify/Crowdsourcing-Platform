<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:48 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnairePossibleAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_possible_answers';
    protected $dates = ['deleted_at'];
}