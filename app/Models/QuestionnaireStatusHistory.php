<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/11/18
 * Time: 3:58 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class QuestionnaireStatusHistory extends Model
{
    protected $table = 'questionnaire_status_history';

    public function status()
    {
        return $this->hasOne(QuestionnaireStatus::class, 'id', 'status_id');
    }
}