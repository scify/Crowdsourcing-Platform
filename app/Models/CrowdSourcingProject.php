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
        'name', 'slug', 'motto', 'description', 'about',  'footer', 'img_path',
        'logo_path', 'user_creator_id', 'language_id', 'status_id', 'sm_title',
        'sm_description', 'sm_keywords', 'sm_featured_img_path'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, 'project_id', 'id');
    }

    public function language() {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function status() {
        return $this->hasOne(CrowdSourcingProjectStatusLkp::class, 'id', 'status_id');
    }
}
