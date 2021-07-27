<?php

namespace App\Models\Questionnaire;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireHtml extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_html';
    protected $dates = ['deleted_at'];
}
