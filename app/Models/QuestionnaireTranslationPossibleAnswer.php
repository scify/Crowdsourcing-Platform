<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/18/18
 * Time: 3:11 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireTranslationPossibleAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_translation_possible_answers';
}