<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrowdSourcingProject extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crowd_sourcing_projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'motto', 'description', 'about', 'questionnaire_section_title', 'footer', 'img_path',
        'logo_path', 'user_creator_id', 'language_id'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, 'project_id', 'id');
    }
}
