<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:43 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireLanguage extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_languages';
    protected $dates = ['deleted_at'];
}