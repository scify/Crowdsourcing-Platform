<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:35 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireResponse extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_responses';
    protected $dates = ['deleted_at'];
}