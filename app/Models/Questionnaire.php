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

class Questionnaire extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaires';
    protected $dates = ['deleted_at'];

    public function defaultLanguage()
    {
        return $this->hasOne(Language::class, 'id', 'default_language_id');
    }

    public function project()
    {
        return $this->belongsTo(CrowdSourcingProject::class, 'project_id', 'id');
    }

    public function statusHistory()
    {
        return $this->hasMany(QuestionnaireStatusHistory::class, 'questionnaire_id', 'id');
    }
}